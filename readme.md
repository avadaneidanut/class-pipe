# ClassPipe

ClassPipe is a personal apropach to pipe class methods and dynamically add subscribers to any methods.

For example, let's say you want to have a clean Logger class that stores messages into an array:
```php
Class Logger{
    public $messages = [];
    public function store($message){
        $this->messages[] = $message;
    }
}
```
If you want to add a new functionality, let's say store the message into db you will have to create a new method in your class that interacts with database and so one.

Ussing ClassPipe, Logger Class
```php
class Logger Extends ClassPipe{
    public $messages = [];
    public $pipes = [
        'store' => 'message:Store a new message'
    ];
    
    public function __construct(){
        // register any default subscribers here
        $this->subscriber('store', function($message){
            $this->messages[] = $message;
        });
    }
    
    public function store(){
        $this->broadcast(func_get_args());
    }
}
```
In your code, if you want to quickly add messages to database
```php
$pdo = new PDO();
$logger = new Logger;
$logger->subscribe('store', function($message) use($pdo){
    $pdo->query("INSERT INTO table VALUES ('$message')");
});
```

We added a new subscriber and now when we log a new message, it will be automatically broadcasted among the subscribers, in our example store it in the array and save it to database.

### Available methods
```php
/**
 * List registered pipes and signatures
 * 
 * @return void
 */
public function pipes();

/**
 * Add a new subscriber to specified pipe.
 *
 * @param  string    $pipe action pipe
 * @param  callbable $subscriber
 * @return void                
 */
public function subscriber($pipe, \Closure $subscriber);

/**
 * Broadcast to all subscribers from specifed pipe.
 *
 * @param  array $pipe action pipe
 * @param  array $args arguments to be passed to subscribers
 * @return void
 */
public function broadcast($pipe, array $args);
```

### Instalation
> composer require avadaneidanut/class-pipe

### Development

Want to contribute? Great! I can't wait for your ideeas.
