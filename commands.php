<?


abstract class commands{
    protected $stek=[],$out=[];
    protected $number=NULL;
    protected $IP=1;
    protected $task=true;
    
    
    public function __construct(array $stek,$number) {
        $this->stek=$stek;
        $this->out=[];
        if(!sizeof($stek))$this->task=false;
    }
    function task(){ // проверка, можноли продолжнать выполнение этой задачи или переход к следующей
        return $this->task;
    }
    function get_out(){ // считываем выход команды
        return $this->out;
    }
    function get_iteration(){ // номер итерации (для команд G и _IF)
        return $this->IP;
    }
    abstract function execute();
}


//  [число] добавляет число на вершину стека; $IP++
class NUMBER extends commands{
    // констурктор переопределен, тк стек при вызове может быть пустой (конструктор родителя вернет false)
    // И нам нужно число положить на верх стека.
    public function __construct(array $stek,$number) {
        $this->stek=$stek;
        $this->out=[];
        $this->number=$number;
        $this->task=true;
    }
    
    function execute(){
        array_unshift($this->stek, $this->number);
        return $this->stek;
    }
}
//  IF(заменяем на _IF)      снимает с вершины стека $q и затем снимает с вершины $p. если $p==0, то $IP = $IP+$q+3; иначе $IP++
class _IF extends commands{
    function execute() {
        $q=array_shift($this->stek);
        $p=array_shift($this->stek);
        if($p==0)$this->IP=$q+3;
        return $this->stek;
    }
}
//  G       снимает элемент $p с вершины стека и перемещает указатель команд: $IP+=$p-2
class G extends commands{
    function execute() {
        $p=array_shift($this->stek);
        $this->IP=$p-2;
        return $this->stek;
    }
}
//  DUP     снимает элемент с вершины стека и дважды добавляет его на вершину стека (т.е. дублирует элемент на вершине); $IP++
class DUP extends commands{
    function execute() {
        $p=array_shift($this->stek);
        array_unshift($this->stek, $p);
        array_unshift($this->stek, $p);
        return $this->stek;
    }
}
//  DEC     снимает с вершины стека $p кладёт на вершину стека $p-1; $IP++
class DEC extends commands{
    function execute() {
        $p=array_shift($this->stek);
        array_unshift($this->stek, $p-1);
        return $this->stek;
    }
}
//  DROP    снимает элемент с вершины стека; $IP++
class DROP extends commands{
    function execute() {
        array_shift($this->stek);
        return $this->stek;
    }
}
//  MOVE    снимает с вершины стека $q и затем $p. далее добавляет элемент $p на $q-ю позицию относительно вершины в стек; $IP++
class MOVE extends commands{
    function execute() {
        $q=array_shift($this->stek);
        $p=array_shift($this->stek);
        array_splice( $this->stek, $q, 0, array($p) );
        return $this->stek;
    }
}
//  CHR     снимает число $p с вершины стека и добавляет символ, равный chr($p+2), на вершину стека; $IP++
class CHR extends commands{
    function execute() {
        $p=array_shift($this->stek);
        array_unshift($this->stek, chr($p+2));
        return $this->stek;
    }
}
//  OUT     снимает элемент с вершины стека и отправляет его в выход; $IP++
class OUT extends commands{
    function execute() {
        $p=array_shift($this->stek);
        $this->out[]=$p;
        return $this->stek;
    }
}
//  +(заменяем на PLUS)       снимает с вершины стека $p и $q и кладет на вершину стека $p+$q; $IP++
class PLUS extends commands{
    function execute() {
        $q=array_shift($this->stek);
        $p=array_shift($this->stek);
        array_unshift($this->stek,$q+$p);
        return $this->stek;
    }
}
//  *(заменяем на SHARE)       снимает с вершины стека $p и $q и кладет на вершину стека $p*$q; $IP++
class SHARE extends commands{
    function execute() {
        $q=array_shift($this->stek);
        $p=array_shift($this->stek);
        array_unshift($this->stek,$q*$p);
        return $this->stek;
    }
}