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
Sometimes you want on change some attribute set value to another attribute. This extention provide that.<br>
Attach behavior to model:
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
With this configuration behavior set current timestamp to ```ClosedOn``` attribute when ```Status``` will be changed from ```null``` to ```1```. When ```Rel_DealStage``` will changed ```LastStageChange``` will containt current timestamp.
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
      ],
      'values' => [
          'ClosedOn' => 'my own value',
          'LastStageChange' => 'my own value'
      ]
  ]
}
```
As you can see from above example you can set own value for each attribute.<br>
Also you can change default value for all attributes:
```php
public function behavior(){
  [
    'class' => AttrsWatcherBehavior::className(),
    'attributes' => [
          'Status' => [
              AttrsWatcherBehavior::ATTRIBUTE => 'ClosedOn',
          ]
      ],
      'values' => function(){
        return time()-100;
      }
  ]
}
```
