<?php
namespace Framework
{
    use Framework\Base as Base;
    use Framework\Configuration as Configuration;
    use Framework\Core\Exception as Exception;

    class Configuration extends Base
    {
        /**
         * @readwrite
         */
        protected $_type;
        /**
         * @readwrite
         */
        protected $_options;

        protected function _getExceptionForImplemenatation($method)
        {
            return new Exception\Implementation("{$method} method not implemented");
        }

        public function initialize()
        {
            if(!$this->type)
            {
                throw Exception\Argument("Invalid type");
            }
            switch($this->type)
            {
                case "ini":
                {
                    return new Configuration\Driver\Ini($this->options);
                    break;
                }
                default:
                {
                    throw Exception\Argument("Invalid type");
                    break;
                }
            }
        }
    }
}