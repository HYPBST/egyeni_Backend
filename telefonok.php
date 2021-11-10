<?php

class Telefon{
    
    private $id;
    private $gyarto;
    private $modell;
    private $tarhely;
    private $memoria;
    private $kiadas;

    public function __construct(string $gyarto, string $modell, int $tarhely, int $memoria, DateTime $kiadas) {
        $this->gyarto = $gyarto;
        $this->modell = $modell;
        $this->tarhely = $tarhely;
        $this->memoria = $memoria;
        $this->kiadas = $kiadas;
    }
    public function uj(){
        global $db;
        $db->prepare("INSERT INTO telefon (gyarto, modell, tarhely, memoria, kiadas)
                    VALUES ( :gyarto, :modell, :tarhely, :memoria, :kiadas);")
            ->execute([
                ':gyarto' => $this->gyarto,
                ':modell' => $this->modell,
                ':tarhely' => $this->tarhely,
                ':memoria' => $this->memoria,
                ':kiadas' => $this->kiadas->format("Y-m-d"),
            ]);
    }

    public static function torol(int $id)
    {
        global $db;
        $db->prepare("DELETE FROM telefon WHERE id = :id")
            ->execute([':id' => $id]);
    }

    public static function getById(int $telefonid):Telefon
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM telefon WHERE id = :id");
        $stmt->execute([':id' => $telefonid]);
        $t = $stmt->fetchAll();
        $bejegyzes = new Telefon($t[0]['gyarto'], $t[0]['modell'], $t[0]['tarhely'], $t[0]['memoria'], new DateTime($t[0]['kiadas']));
        $bejegyzes->id = $t[0]['id'];
        return $bejegyzes;
    }
    public function update()
    {
        global $db;
        
        $db->prepare('UPDATE telefon
                    SET gyarto = :gyarto, modell = :modell, tarhely = :tarhely, memoria = :memoria, kiadas = :kiadas
                    WHERE id = :id;')
                    ->execute([
                        ':gyarto' => $this->gyarto,
                        ':modell' => $this->modell,
                        ':tarhely' => $this->tarhely,
                        ':memoria' => $this->memoria,
                        ':kiadas' => $this->kiadas->format("Y-m-d"),
                        ':id' => $this->id,
                    ]); 
    }
    public function getgyarto():string
    {
        return $this->gyarto;
    }
    public function setgyarto(string $gyarto):void
    {
        $this->gyarto = $gyarto;
    }

    public function getmodell():string
    {
        return $this->modell;
    }
    public function setmodell(string $modell):void
    {
        $this->modell = $modell;
    }

    public function gettarhely():int
    {
        return $this->tarhely;
    }
    public function settarhely(int $tarhely):void
    {
        $this->tarhely = $tarhely;
    }
    
    public function getmemoria():int
    {
        return $this->memoria;
    }
    public function setmemoria(int $memoria):void
    {
        $this->memoria = $memoria;
    }

    public function getkiadas():DateTime
    {
        return $this->kiadas;
    }
    public function setkiadas(DateTime $kiadas):void
    {
        $this->kiadas = $kiadas;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public static function osszes():array
    {
        global $db;

        $t = $db->query("SELECT * FROM telefon")
            ->fetchAll();
        $eredmeny = [];
        foreach ($t as $elem) {
            $bejegyzes = new Telefon($elem['gyarto'], $elem['modell'], $elem['tarhely'], $elem['memoria'], new DateTime($elem['kiadas']));
            $bejegyzes->id = $elem['id'];
            $eredmeny[] = $bejegyzes;
        }
        return $eredmeny;
    }
}