<?php

namespace frontend\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use libphonenumber\PhoneNumberFormat;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $phone;
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'body'], 'required'],
            [['phone'], PhoneInputValidator::class, 'region' => ['ru']],
            [['name'], 'string'],
            ['email', 'email'],
            [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator2::class
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reCaptcha' => 'Verification Code',
            'body' => 'Message'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setReplyTo([$this->email => $this->name])
            ->setSubject('Feedback Notification Message')
            ->setTextBody($this->body)
            ->send();
    }
}
