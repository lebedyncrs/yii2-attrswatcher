Attribute watcher for Yii2
========================
Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lebedyncrs/yii2-attrswatcher
```

or add

```json
"lebedyncrs/yii2-attrswatcher": "*"
```

to the require section of your composer.json.
Usage
------------
Sometimes you want on chage some attribute save value to another attribute. This extention provide that.
```php
public function behavior(){
  [
    'class' => AttrsWatcherBehavior::className(),
    'attributes' => [
          'Status' => [
              AttrsWatcherBehavior::ATTRIBUTE => 'ClosedOn',
              AttrsWatcherBehavior::FROM => null
              AttrsWatcherBehavior::TO => 1
            ],
            'Rel_DealStage' => [
                   AttrsWatcherBehavior::ATTRIBUTE => 'LastStageChange',
            ]
      ]
  ]
}
```
With this configuration behavior set current timestamp to ```phpClosedOn``` attribute when ```phpStatus``` will be changed from ```phpnull``` to ```php1```
