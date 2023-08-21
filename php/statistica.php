<?php
 require "../../Galeazzi/gestionedati.php";

class Statistica
{
    public $studente = null;
    public $elenco = array();

    public function __construct( $stud = null)
    {
        if($stud===null)        
        {
		 
            $gd=new GestioneDati();
			//echo count(json_decode($gd->GetDati()));
            $this->elenco = json_decode($gd->GetDati());
			//echo ",,,".count($this->elenco);
			}
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
		 

        if ($this->studente === null) 
		{
            foreach ($this->elenco as $studente) {
                foreach ($studente->Valutazioni as $valutazione) {
                    $allDates[] = $valutazione->Data;
                }
            }
			$sortedDates = array_values(array_unique($allDates));	
			sort($sortedDates);
        } else 
		{
			 
            $sortedDates = array_values(array_unique(array_sort($this->studente->Valutazioni, function($valutazione) {
                return $valutazione->Data;
            })));
		
        }
		if($this->studente === null) 
			$numerostud=count($this->elenco);
		else
			$numerostud=1;
		
		//echo $numerostud;
		//var_dump($this->elenco);
        /*$header=array('Data');
        foreach ($this->elenco as $studente) 
		{
			 
            array_push($header,$studente->Cognome);
        }
        $datiFormattati = array(
            $header
        );*/
		 //var_dump($datiFormattati);
        
	
        $valutazioniAllineate = array();

        if ($this->studente === null) 
		{
            foreach ($this->elenco as $studente) 
			{
                $valutazioniAllineate[$studente->Cognome] = array();
                $ultimovoto = 1;

                foreach ($sortedDates as $data) 
				{
                    $valutazione = null;

                    foreach ($studente->Valutazioni as $v) 
					{
                        if ($v->Data=== $data) 
						{
                            $valutazione = $v->Voto;
                            
                        }
                    }

                    if ($valutazione !== null) 
					{
                        $ultimovoto = $valutazione;
                        $valutazioniAllineate[$studente->Cognome][] = $ultimovoto;
                    } else {
                        $valutazioniAllineate[$studente->Cognome][] = $ultimovoto;
                    }
                }
            }
        } 
		else {
            $valutazioniAllineate[$this->studente->Cognome] = array();
            $ultimovoto = 1;

            foreach ($sortedDates as $data) 
			{
                $valutazione = null;

                foreach ($this->studente->Valutazioni as $v) 
				{
                    if ($v->Data === $data) 
					{
                        $valutazione = $v->Voto;
                       
                    }
                }

                if ($valutazione !== null) {
                    $ultimovoto = $valutazione;
                    $valutazioniAllineate[$this->studente->Cognome][] = $valutazione;
                } else {
                    $valutazioniAllineate[$this->studente->Cognome][] = $ultimovoto;
                }
            }
        }
		//var_dump($valutazioniAllineate);

        $dati->Date = $sortedDates;
        $dati->Valutazioni = $valutazioniAllineate;
        return $dati;
    }

    public function ChartDataSerie()
    {
        $elenco=$this->generaSerieMultiple();
		
		$header=array('Data');
		if($this->studente===null)
		{
			foreach ($this->elenco as $studente) 
			{
				 
				array_push($header,$studente->Cognome);
			}
		}
		else
			array_push($header,$this->studente->Cognome);
		
        $datiFormattati = array(
            $header
        );
		//var_dump($elenco->Valutazioni);
		
		
		
       /* $numerostud=count($elenco->Valutazioni);
        $header=array('Data');
        for ($j=0;$j<$numerostud;$j++) 
        {
            array_push($header,$j);
        }
        $datiFormattati = array(
            $header
        );*/
		var_dump($datiFormattati);
       echo"<br><br><br>";
		if($this->studente===null)
		{		
			foreach ($elenco->Date as $i => $data) 
			{
				$giorno=array($data);

				for ($j=0;$j<$numerostud;$j++) 
				{
					$giorno[]=$elenco->Valutazioni[$j];
				}
				$datiFormattati[]=$giorno;
			   
			}
		}
		else
		{
			foreach ($this->studente->Valutazioni as $v)
			{
				$giorno[]=$v;
			}
			$datiFormattati[]=$giorno;
		}
		var_dump($datiFormattati);
       echo"<br><br><br>";
	   print_r($datiFormattati);
	   
	   $df="";
	   for ($i=0;$i<count($datiFormattati);$i++) 
		{
			$df.="[";
			 for ($j=0;$j<count($datiFormattati[$i]);$i++) 
			{
				 $df.=is_numeric($datiFormattati[$i][$j])?$datiFormattati[$i][$j]:("'".$datiFormattati[$i][$j]."',");
			}
			$df.="],<br>";
		}
		 echo"<br><br><br>";
		 echo $df;
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
