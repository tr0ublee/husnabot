# husnabot
### A very simple Telegram bot that made just for fun. All credits go to [Hüsna Yılmaz](https://github.com/arfias)
[Say /start to @husnabot](https://telegram.me/husnabot)
---
**b0t.php** and **b0t.functions.php** are the files developed and customized for contributors to easily add new features to the bot.

Here's a basic template:
**b0t.php**
```php
$husnab0t->addCommand("word","function_name_to_call");
/* first thing to do is register command to listener */
```
**b0t.functions.php**
```php
function function_name_to_call()
{
        global $husnab0t;
        $husnab0t->sendMessage("good job!");
}
/* after calling addCommand with the parameters above, bot automatically calls the given function each time it encounters the "word"
```

To make it clear, here's a working example:

**b0t.php**
```php
$husnab0t->addCommand("fotoad","fotoadFunc");
```

**b0t.functions.php**
```php
/* fotoad Function STARTS */
function fotoadFunc(){
        global $husnab0t;
        $response = husnaCurl("http://www.funcage.com/?");
        $result = "";
        preg_match_all('/src="([^"]+)"/',$response, $result);
        $sonhal = "http://www.funcage.com".$result[1][1];
        $husnab0t->sendPhoto($sonhal);
}
/* fotoad Function ENDS */
```

**That's it!**

When some say "fotoad" in a chat with husnab0t, fotoadFunc() will be automatically called.
---

You can use husnaCurl($url) function to make cURL requests within functions.

More information coming soon!
