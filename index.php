<?php
$estacionamento = criarEstacionamento();
echo 'Quantidade de vagas: '.$estacionamento->getCountVaga();

function criarEstacionamento() :Estacionamento
{
    $estacionamento = new Estacionamento;
    $numAndares = rand(1, 10);

    for ($a = 1; $a <= $numAndares; $a++) {
        $andar = new Andar;
        $numFileiras = rand(1, 10);
        echo $a.'º Andar <br>';

        for ($f = 1; $f <= $numFileiras; $f++) {
            $fileira = new Fileira;
            $numVagas = rand(1, 10);

            for ($v = 1; $v <= $numVagas; $v++) {
                $vaga = new Vaga(rand(0, 2));
                $fileira->addVaga($vaga);
                echo $v.'|';
            }

            echo '<br>';

            $andar->addFileira($fileira);
        }

        echo '<hr>';

        $estacionamento->addAndar($andar);
    }

    return $estacionamento;
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

        foreach ($this->andares as $andare) {
            $countVagas += $andare->getCountVaga();
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

        $this->size = self::VAGA_SIZES[$size];
    }

    public function ocuparVaga() :boll
    {
        $this->disponivel = false;

        return $this->disponivel;
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