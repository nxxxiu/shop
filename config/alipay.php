<?php
return[
    //应用ID,您的APPID。
    'app_id' => "2016092500594767",

    //商户私钥
    'merchant_private_key' => "MIIEpAIBAAKCAQEAvkzuwfk/R9j0OkBjGb/KfiTUoDsnKGb2cChHXk6aLZrHAEZrhbHJIVPwzeKHDc05mVmO3Ggg5Uq8XghwZY70fVfIO7ObMARxg1mJ2hAVYKeOJCU4wknZ5f7Tq53lsBL+ZR3H4KTWCdODKTh6arKT1Q5xSe1jinvzx5kE689e2z41BOV0LRQvIlPN/CdnVxnuq0OnXpyQoqTGk0PyjbLjDgegXLp6aonHuW7GV3m5LWlGJF74q2U2jgrI14VHtotpb83PHE4S6/0YCr1gbI1Ouum5Q3dIKoXwXWC1zN81/+22x/RysDwQc2HRekgbqJJeY9ha4fly7Z/+pHEVhjSgDwIDAQABAoIBAQCkpuvt6TpXb9/ghtU38jnB6xwNhyDaVDvlzvPxJRFBZCnKkyN1Cd58d6Rifx1bU7YCePqiuXW87m0M70BQnt/rk4gsH7qmUTHl9BLSGhhlCJRzscDqWfuuhE2gr32MWuLBmoLWW8jVt6xEfhltOBWwwk5DKKJ3r8e9ayhW35WzGyHNeYVj1I0EIZHmuUx66qiEQiFHibciOZSUU4h724rSbS3KIyBXHqDWsqjBMGBgUL5XzIzxLmZ8JAPOZwxUkkNa8uuo4x0espC0rd5IaKaFYjqgeg5nYDgMETD98amod+EC61lFlBrzNK5c9S9aErU7ZQ/MK/elKDRhgbdljRgBAoGBAN7cP5iBvr19HqRo1RHiJiGhc2LfQ0c8k/XP71cdnk3CZ3/Mzg4dcIMtRLlSR9nKPli5tCsYUqiy5oe0YiIFU9be3f9wB6HZkA0rSwG6s41Bzd+OVOwT5yATdb8EHedvStZucCHPBO8yMFjTE12JKut4RX9X+0c/5lHMpwc0kPZnAoGBANqZNfQYuXw5gxOUI0tlrbe75XrGO9IoTT7JN5VM9MUNQDLN+BPpa1zd2JKQo5AkiPuuOtFXSHqYD3N5Viszre30qiWmt/e1mw8HnaAJ8hqMI6bXka21CZRHRpIqQpKi+hfZdgfYoZn/iJRPyTOm6D8i7maV28UHJxFZkU+7FPAZAoGBALF6Fs897Ad9P8zQi3Y9cf5wU7KWeD6f2Hj2ifUHak0kl0XodOQ6v6JHh6ZKB1xCulnwMbHsIc+lAP9rQIc1VOoV/BbzQbC70QMbyhTreRfyIqB4+dozk2kw9iEThzkKoT+ZHYVfFt/iSSxDk/V2Sg7Rbg8Wos6/7YyQ/Sc4zoTbAoGAMkQU0gJ1dIlNCM2BqC7DWYKNbEP1MYgu6wceDujZSA6Z+pS+POXp2DrzOBCma9ja3vTbdZPaiMY6l1UJaXnCvvsJvQqvNvi9pSEdL9XZpB0hfZYIW6dLgps5MRcio9FyLNXGfFtmHaFS6LfIDmaM9Se1JkXDeXUBmM29ylW8pNECgYBkWqNx3cmCjjzMxUpruJHaCubVKQLss9MaZbxVsk7ucgAnbaMVmw85AmFLrdT1OxgzxsqE2PQTbzorpUdi9q49jxJ+COGdTU+lIQW2RFqaDPLFVkBh6o7Mmtp5LF7ATSHzmoUMxauoqBTQYFGTNC9h9qerhmGFlyJ9KdUrCBH67w==",

    //异步通知地址
    'notify_url' => "http://localhost/www/alipay/notify_url.php",

    //同步跳转
    'return_url' => "http://localhost/www/alipay/return_url.php",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvkzuwfk/R9j0OkBjGb/KfiTUoDsnKGb2cChHXk6aLZrHAEZrhbHJIVPwzeKHDc05mVmO3Ggg5Uq8XghwZY70fVfIO7ObMARxg1mJ2hAVYKeOJCU4wknZ5f7Tq53lsBL+ZR3H4KTWCdODKTh6arKT1Q5xSe1jinvzx5kE689e2z41BOV0LRQvIlPN/CdnVxnuq0OnXpyQoqTGk0PyjbLjDgegXLp6aonHuW7GV3m5LWlGJF74q2U2jgrI14VHtotpb83PHE4S6/0YCr1gbI1Ouum5Q3dIKoXwXWC1zN81/+22x/RysDwQc2HRekgbqJJeY9ha4fly7Z/+pHEVhjSgDwIDAQAB",
];