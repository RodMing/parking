<?php
$estacionamento = EstacionamentoFactory::make();
echo 'Quantidade de vagas: '.$estacionamento->getCountVaga();

class EstacionamentoFactory
{
    public static function make(int $qtdAndares = 5, int $qtdFileiras = 5, int $qtdVagasPorFileira = 5) :Estacionamento
    {        
        $estacionamento = new Estacionamento;

        for ($a = 1; $a <= $qtdAndares; $a++) {
            $andar = new Andar;

            for ($f = 1; $f <= $qtdFileiras; $f++) {
                $fileira = new Fileira;

                for ($v = 1; $v <= $qtdVagasPorFileira; $v++) {
                    $vaga = new Vaga(rand(0, 2));
                    $fileira->addVaga($vaga);
                }
                
                $andar->addFileira($fileira);
            }

            $estacionamento->addAndar($andar);
        }

        return $estacionamento;
    }
}

class Estacionamento
{
    private $andares = [];

    public function addAndar(Andar $andar) :Estacionamento
    {
        array_push($this->andares, $andar);

        return $this;
    }

    public function getAndares() :array
    {
        return $this->andares;
    }

    public function getCountVaga() :int
    {
        $countVagas = 0;

        foreach ($this->andares as $andar) {
            $countVagas += $andar->getCountVaga();
        }

        return $countVagas;
    }
}

class Vaga
{
    const VAGA_SIZES = [
        0 => 'Compacta',
        1 => 'Normal',
        2 => 'Grande'
    ];

    private $size;
    private $disponivel = true;

    public function __construct(int $size = 0)
    {
        if (!array_key_exists($size, self::VAGA_SIZES)) {
            throw new \Exception('Tamanho de vaga invalido');
        }

        $this->size = $size;
    }

    public function ocuparVaga() :boll
    {
        $this->disponivel = false;

        return $this->disponivel;
    }
    
    public function getSize()
    {
        return $this->size;   
    }
    
    public function getSizeLabel()
    {
        return self::VAGA_SIZES[$this->size];
    }
}

class Fileira
{
    private $vagas = [];

    public function addVaga(Vaga $vaga) :Fileira
    {
        array_push($this->vagas, $vaga);

        return $this;
    }

    public function getCountVaga() :int
    {
        return count($this->vagas);
    }
}

class Andar
{
    private $fileiras = [];

    public function addFileira(Fileira $fileira) :Andar
    {
        array_push($this->fileiras, $fileira);

        return $this;
    }

    public function getCountVaga() :int
    {
        $countVagas = 0;

        foreach ($this->fileiras as $fileira) {
            $countVagas += $fileira->getCountVaga();
        }

        return $countVagas;
    }
}
