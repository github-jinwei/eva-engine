<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Validator
 */

namespace Eva\Validator\Db;

use Zend\Validator\Exception,
    Zend\ServiceManager\ServiceLocatorAwareInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Confirms a record does not exist in a table.
 *
 * @category   Zend
 * @package    Zend_Validate
 */
class RecordExists extends AbstractDb
{
    public function isValid($value, $context = null)
    {
        /*
         * Check for an adapter being defined. If not, throw an exception.
         */
        if (null === $this->adapter) {
            throw new Exception\RuntimeException('No database adapter present');
        }

        $valid = true;
        $this->setValue($value);

        $excludeField = $this->exclude['field'];
        if($excludeField && isset($context[$excludeField])){
            $this->exclude['value'] = $context[$excludeField];
        }

        $result = $this->query($value);
        if (!$result) {
            $valid = false;
            $this->error(self::ERROR_NO_RECORD_FOUND);
        }

        return $valid;
    }
}
