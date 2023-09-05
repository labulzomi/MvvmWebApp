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
	function confrontoPerData($a, $b) 
	{
		//echo $a->Data."-".$b->Data."<br>";
		return strcmp($a->Data, $b->Data);
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
            foreach ($this->studente->Valutazioni as $valutazione) {
                $allDates[] = $valutazione->Data;
            }
            $sortedDates = array_values(array_unique($allDates));	
           
            sort($sortedDates);
			
			//echo $numerostud;
		 //var_dump($sortedDates);
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
			$valutazioniAllineate=$this->studente->Valutazioni;
			//var_dump($valutazioniAllineate);
			usort($valutazioniAllineate, array($this,'confrontoPerData'));
			//var_dump($valutazioniAllineate);
			
			
			//var_dump($valutazioniAllineate);
            /*$valutazioniAllineate[$this->studente->Cognome] = array();
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
            }*/
        }
	 
//echo "<br><br>";
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
	
	   
		if($this->studente===null)
		{		
			foreach ($elenco->Date as $i => $data) 
			{
				$giorno=array($data);

			   foreach ($elenco->Valutazioni as $nome=>$studente) 			
					$giorno[]=$studente[$i];
				$datiFormattati2[]=$giorno;			   
			}
		}
		else
		{
            foreach ($elenco->Valutazioni as $i => $v) 
			{
				$giorno=array($v->Data,$v->Voto);
                
                $datiFormattati2[]=$giorno;
            }
           // var_dump($datiFormattati2);
		}
		//var_dump($datiFormattati);
       //echo"<br>dfsfs<br><br>";
	   //print_r($datiFormattati);
	   //var_dump($datiFormattati);
					
	   $df="";
	   for ($i=0;$i<count($datiFormattati2);$i++) 
		{
			$df.="[";
			 
		 	 for ($j=0;$j<count($datiFormattati2[$i]);$j++) 
			{ /*echo "qio";
                var_dump($datiFormattati2[$i]);
                echo "<br>-";*/
				if($j==count($datiFormattati2[$i])-1)
					$df.=is_numeric($datiFormattati2[$i][$j])?($datiFormattati2[$i][$j]):("new Date(".explode("-",$datiFormattati2[$i][$j])[0].",".(explode("-",$datiFormattati2[$i][$j])[1]-1).",".explode("-",$datiFormattati2[$i][$j])[2].")");
				else
				 $df.=is_numeric($datiFormattati2[$i][$j])?($datiFormattati2[$i][$j].","):("new Date(".explode("-",$datiFormattati2[$i][$j])[0].",".(explode("-",$datiFormattati2[$i][$j])[1]-1).",".explode("-",$datiFormattati2[$i][$j])[2])."),";
			} 
			 
			 if($i==count($datiFormattati2)-1)
				 $df.="]";
			 else
				 $df.="],";
		}
		 
 
		 $this->jsChart($header,$df);
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
	
	
	
	public function jsChart($header,$df)
	{
		echo "
		google.charts.load('current', {packages: ['corechart', 'line']});
		google.charts.setOnLoadCallback(drawCurveTypes);

		function drawCurveTypes() 
		{
		 
		  var data = new google.visualization.DataTable();";
		  foreach($header as $i=>$h)
			if($i==0)
			echo "data.addColumn('date', '".$h."');";	
				else
			echo "data.addColumn('number', '".$h."');";	

		echo"
		  data.addRows([";
		
		echo $df;
		  echo "]);

		  var options = 
          {
            width: 700,
            height: 400,
            title: 'Andamento Valutazioni',
			hAxis: {
			  title: 'Periodo'
			},			 
            vAxis: {
                title: 'Voto',
                viewWindow: {
                    min: 1,
                    max: 10
                }
            },
			series: {
			  1: {curveType: 'function'}
			},
            legend: { position: 'right' }
		  };

		  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		  chart.draw(data, options);
		}";

		$distr_voti=$this->distribuzioneVoti();

        echo "google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([['Voti', 'Occorrenze'],";
		$i=0;
          foreach($distr_voti as $key=>$value)
		  {
			if($i!=0)			
				echo ",['$key',$value]";
			else
				echo "['$key',$value]";
			$i++;
		  }
        echo "]);

         
		var options = 
          {
            width: 700,
            height: 400,
           title: 'Distribuzione Valutazioni',
			 		 
             
			 
            legend: { position: 'right' }
		  };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
		";
		       
	}
}
