<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@rest', dirname(dirname(__DIR__)) . '/rest');
Yii::setAlias('@certFile', dirname(dirname(__DIR__)) . '/cert/cacert.pem');
Yii::setAlias('@imagePath', dirname(dirname(__DIR__)) . '/frontend/web/book-images');
