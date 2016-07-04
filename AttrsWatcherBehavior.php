<?php

namespace lebedyncrs\attrswatcher;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\base\InvalidConfigException;

/**
 * 
 */
class AttrsWatcherBehavior extends Behavior {

    const FROM = 'from';
    const TO = 'to';
    const ATTRIBUTE = 'attribute';

    /**
     * @var array
     */
    public $attributes;

    /**
     * @var mixed 
     */
    public $values;

    /**
     * @inheritdoc
     */
    public function events() {
        return [
            BaseActiveRecord::EVENT_AFTER_VALIDATE => 'setAttribute',
        ];
    }

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        if (is_null($this->values)) {
            $this->values = time();
        }
    }

    public function setAttribute($event) {
        foreach ($this->attributes as $key => $value) {
            if (is_string($key) && $this->owner->hasAttribute($key)) {
                $attrName = $key;
            } elseif (is_string($value) && $this->owner->hasAttribute($key)) {
                $attrName = $value;
            }
            if (!isset($attrName)) {
                throw new InvalidConfigException("Attribute dosen't exist");
            }
            if ($this->isAttrChanged($attrName)) {
                $this->owner->{$this->attributes[$attrName][self::ATTRIBUTE]} = $this->getValue($this->attributes[$attrName][self::ATTRIBUTE]);
            }
        }
    }

    /**
     * check if attr is changed  
     * @param string $attrName
     * @return boolean
     */
    public function isAttrChanged($attrName) {
        if ($this->owner->isAttributeChanged($attrName)) {
            $fromExsistence = isset($this->attributes[$attrName][self::FROM]);
            $toExsistence = isset($this->attributes[$attrName][self::TO]);
            if ($fromExsistence && $toExsistence) {
                if ($this->attributes[$attrName][self::FROM] == $this->owner->getOldAttribute($attrName) && $this->owner->{$attrName} == $this->attributes[$attrName][self::TO]) {
                    return true;
                }
                return false;
            } elseif ($fromExsistence) {
                if ($this->attributes[$attrName][self::FROM] == $this->owner->getOldAttribute($attrName)) {
                    return true;
                }
                return false;
            } elseif ($toExsistence) {
                if ($this->attributes[$attrName][self::TO] == $this->owner->{$attrName}) {
                    return true;
                }
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $attrName
     * @return mixed
     */
    public function getValue($attrName) {
        if (is_array($this->values) && isset($this->values[$attrName])) {
            return $this->values[$attrName];
        }
        if(is_callable($this->values)) {
            return call_user_func($this->values);
        }
        return time();
    }

}
