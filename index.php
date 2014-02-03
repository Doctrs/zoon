<?

require 'commands.php';

class stek{
    
    public $stek=[];
    private $out=[];
    private $commands=[];
    private $IP=0;
    
    public function __construct(array $arr) {
        $this->stek=$arr;
    }
    
    function command(array $arr){
        $this->commands=$arr;
        while(true){ // бесконечный цикл с проверкой в фуенкции execute
            if(!$this->execute())break;
        }
        // возвращаем выход задачи
        return $this->out;
    }
    
    function execute(){
        // если нет команды в задаче то переходим к следующей
        if(!isset($this->commands[$this->IP]))return false;
        
        $item=$this->commands[$this->IP];
        $command=$this->get_command($item);
        // если стек пустой, то переходим к следующей зхадачи
        if(!$command->task())return false;
        $this->stek=$command->execute();
        // забивает выход команды в массив
        $this->out=array_merge($this->out,$command->get_out());
        // увеличиваем номер команды на...
        $this->IP+=$command->get_iteration();
        
        return true;
    }
    
    private function get_command($name){
        // все команды это классы - поэтому заменяем названия команд чтобы можно было назвать ими классы
        $name=str_replace(['+','*','IF'],['PLUS','SHARE','_IF'],$name);
        if(!class_exists($name)){
            // если такого класса не существует то создаем класс ЧИСЛО
            $number=$name;
            $name='NUMBER';
        }
        else{
            $number=NULL;
        }
        return new $name($this->stek,$number);
    }
    
}


class main{
    
    private $text=[];
    private $main_array=[];
    
    public function __construct() {
        $quest_url="http://zoon.ru/job.php?name=rijen&contact=false&cv=false";
        $response=json_decode(file_get_contents($quest_url));
        $this->main_array=$response->task; // получаем массив с 3мя задачами
    }
    
    function start(){
        $return=[];
        foreach($this->main_array as $key=>$check){
            echo 'Iteration: '.$key."\n";
            // для каждой задачи создаем свой класс
            $stek=new stek($return);
            $return=$stek->command($check); // выход из каждой задачи идет на стек следующей
        }
        $this->text=$return;
        return $return;
    }
    
    public function var_dump(){ // на последнем выходе мы должны получить ссылку. После выполнения вызываем этот метод.
        return join('',$this->text);
    }
}




    echo "start \n";
$main=new main();
$main->start();
    echo "result:\n";
    echo $main->var_dump();
