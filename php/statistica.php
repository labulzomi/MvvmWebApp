<?php
 require "../../Galeazzi/gestionedati.php";

class Statistica
{
    private $studente = null;
    private $elenco = array();

    public function __construct( $stud = null)
    {
        if($stud===null)        
        {
            $gd=new GestioneDati();
            $this->elenco = json_decode($gd->GetDati());}
        else
            $this->studente = $stud;
    }

    public function getMediaVoto()
    {
        if ($this->studente === null) {
            return array_sum(array_map(function($studente) {
                return count($studente->Valutazioni) > 0 ? array_sum(array_column($studente->Valutazioni, 'Voto')) / count($studente->Valutazioni) : 0;
            }, $this->elenco)) / count($this->elenco);
        } else {
            return count($this->studente->Valutazioni) > 0 ? array_sum(array_column($this->studente->Valutazioni, 'Voto')) / count($this->studente->Valutazioni) : 0;
        }
    }

    public function getMaxVoto()
    {
        if ($this->studente === null) {
            return max(array_map(function($studente) {
                return count($studente->Valutazioni) > 0 ? max(array_column($studente->Valutazioni, 'Voto')) : 0;
            }, $this->elenco));
        } else {
            return count($this->studente->Valutazioni) > 0 ? max(array_column($this->studente->Valutazioni, 'Voto')) : 0;
        }
    }

    public function getMinVoto()
    {
        if ($this->studente === null) {
            return min(array_map(function($studente) {
                return count($studente->Valutazioni) > 0 ? min(array_column($studente->Valutazioni, 'Voto')) : 0;
            }, $this->elenco));
        } else {
            return count($this->studente->Valutazioni) > 0 ? min(array_column($this->studente->Valutazioni, 'Voto')) : 0;
        }
    }

    public function getNStudenti()
    {
        return $this->studente === null ? count($this->elenco) : 1;
    }

    public function getNValutazioni()
    {
        return $this->studente === null ? array_sum(array_map(function($studente) {
            return count($studente->Valutazioni);
        }, $this->elenco)) : count($this->studente->Valutazioni);
    }

    public function generaSerieMultiple()
    {
        $valutazioniOrdinate = array();
        $dati = new \stdClass();

        $allDates = array();
        $jitterAmount = 0.2;

        if ($this->studente === null) {
            foreach ($this->elenco as $studente) {
                foreach ($studente->Valutazioni as $valutazione) {
                    $allDates[] = $valutazione->Data;
                }
            }
        } else {
            $valutazioniOrdinate = array_values(array_sort($this->studente->Valutazioni, function($valutazione) {
                return $valutazione->Data;
            }));

            foreach ($valutazioniOrdinate as $i => $valutazione) {
                $sameDateCount = count(array_filter($valutazioniOrdinate, function($dp) use ($valutazione) {
                    return $dp->Data == $valutazione->Data;
                }));

                $allDates[] = $valutazione->Data;
                if ($sameDateCount > 1) {
                    for ($j = 1; $j < $sameDateCount; $j++) {
                        $valutazioniOrdinate[$i + $j]->Data->modify('+' . ($j * $jitterAmount) . ' day');
                        $allDates[] = $valutazioniOrdinate[$i + $j]->Data;
                    }
                    $i += $sameDateCount - 1;
                }
            }
        }

        $sortedDates = array_values(array_unique($allDates));
        $valutazioniAllineate = array();

        if ($this->studente === null) {
            foreach ($this->elenco as $studente) {
                $valutazioniAllineate[$studente->ID] = array();
                $ultimovoto = 1;

                foreach ($sortedDates as $data) {
                    $valutazione = null;

                    foreach ($studente->Valutazioni as $v) {
                        if ($v->Data=== $data) {
                            $valutazione = $v;
                            break;
                        }
                    }

                    if ($valutazione !== null) {
                        $ultimovoto = $valutazione->Voto;
                        $valutazioniAllineate[$studente->ID][] = $valutazione->Voto;
                    } else {
                        $valutazioniAllineate[$studente->ID][] = $ultimovoto;
                    }
                }
            }
        } else {
            $valutazioniAllineate[$this->studente->ID] = array();
            $ultimovoto = 1;

            foreach ($sortedDates as $data) {
                $valutazione = null;

                foreach ($valutazioniOrdinate as $v) {
                    if ($v->Data === $data) {
                        $valutazione = $v;
                        break;
                    }
                }

                if ($valutazione !== null) {
                    $ultimovoto = $valutazione->Voto;
                    $valutazioniAllineate[$this->studente->ID][] = $valutazione->Voto;
                } else {
                    $valutazioniAllineate[$this->studente->ID][] = $ultimovoto;
                }
            }
        }

        $dati->Date = $sortedDates;
        $dati->Valutazioni = $valutazioniAllineate;
        return $dati;
    }

    public function ChartDataSerie()
    {
        $elenco=$this->generaSerieMultiple();
        $numerostud=count($elenco->Valutazioni);
        $header=array('Data');
        for ($j=0;$j<$numerostud;$j++) 
        {
            array_push($header,$j);
        }
        $datiFormattati = array(
            $header
        );
        
        foreach ($elenco->Date as $i => $data) 
        {
            $giorno=array($data);

            for ($j=0;$j<$numerostud;$j++) 
            {
                array_push($giorno,$elenco[$J][$i]->Voto);
            }
            $datiFormattati[]=$giorno;
        }
        echo json_encode($datiFormattati);
    }



    public function distribuzioneVoti()
    {
        $dati = array();

        if ($this->studente === null) {
            foreach ($this->elenco as $studente) {
                foreach ($studente->Valutazioni as $valutazione) {
                    if (!array_key_exists($valutazione->Voto, $dati)) {
                        $dati[$valutazione->Voto] = 0;
                    }
                    $dati[$valutazione->Voto]++;
                }
            }
        } else {
            foreach ($this->studente->Valutazioni as $valutazione) {
                if (!array_key_exists($valutazione->Voto, $dati)) {
                    $dati[$valutazione->Voto] = 0;
                }
                $dati[$valutazione->Voto]++;
            }
        }

        return $dati;
    }
}
