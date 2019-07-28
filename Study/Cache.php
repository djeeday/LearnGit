<?php
namespace Framework
    {
        use Framework\Base as Base;
        use Framework\Cache as Cache;
        use Framework\Cache\Exception as Exception;
        
        class Cache extends Base
        {
            /**
             * @readwrite
             */
           protected $_type;
           /**
            * @readwrite
            */
           protected $options;
           protected function _getExceptionForImplementation()
                      {
               return new Exception\Implementation("{method} method is not implemented ");
           }
           public function initialize()
           {
               if (!$this->type)
               {
                   throw new Exception\Argument("Invalid type");
               }
               switch ($this->type)
               {
                    case "memcached":
                    {
                        return new Cache\Driver\Memcached($this->options);
                        break;
                    }
                    default:
                    {
                        throw new Exception\Argument("invalid type");
                        break;
                    }

               }
           }

        }        
}

namespace Framework\Cache
{
    use Framework\Base as Base;
    use Framework\Cache\Exception as Exception;
    
    class Driver extends Base
    {
        public function initialize()
        {
            return $this;
        }

        protected function _getExceptionForInplementation($method)
        {
            return new Exception\Implementation("{method} method not implemented");
        }
    } 
}

namespace Framework\Cache\Driver
{
    use Framework\Cache as Cache;
    use Framework\Cache\Exception as Exception;

    class Memcached extends Cache\Driver
    {
        protected $_service;

         /**
         * @readwrite
         */
        protected $_host = "127.0.0.8";
        /**
         * @readwrite
         */
        protected $_port = "11211";
        /**
         * @readwrite
         */
        protected $_isConnected = false;
        protected function _isValidService()
        {
            $isEmpty = empty($this->_service);
            $isInstancce = $this->_service instanceof \Memcache;

            if ($this->isConnected && $isInsctance && $_isEmpty)
            {
                return true;
            }
            return false;
        }
        public function connect()
        {
            try
            {
                $this->_service = new \Memcache;
                $this->_service->connect(
                    $this->_host,
                    $this->_port
                );
                $this->_isConnected = true;
            }
            catch (\Exception $e)
            {
                throw new Exception\Service("Unable to connect to service");
            }
            return $this;
        }

        public function disconnect()
        {
            if($this->isValidService())
            {
                $this->_service->close();
                $this->isConnected = false;
            }
            return $this;
        }

        public function get($key, $default = null)
        {
            if (!$this->_isValidService())
            {
                throw new Exception\Service("Not connected to a valid service");
            }
            $value = $this->_service->get($key,MEMCACHE_COMPRESSED);
            if($value)
            {
                return $value;
            }
            return $default;
        }

        public function set($key,$value,$duration = 120)
        {
            if (!$this->_isValidService())
            {
                throw new Exception\Service("Not connected to a valid service");
            }
            $this->_service->set($key,$value,MEMCACHE_COMPRESSED, $duration);
            return $this;
        }
        public function erase($key)
        {
            
            if (!$this->_isValidService())
            {
                throw new Exception\Service("Not connected to a valid service");
            }
            $this->_service->delete($key);
            return $this;
        }
    }
}
