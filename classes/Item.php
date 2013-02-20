<?php

/**
 * Class to retrieve item data from the database
 */
class Item {
// Properties

    /**
     * @var string The item's codice
     */
    public $codiceArticolo = null;

    /**
     * @var string The item's description
     */
    public $descrizione = null;

    /**
     * @var string The item's codice fornitore1
     */
    public $codForn1 = null;

    /**
     * @var string The item's codice fornitore2
     */
    public $codForn2 = null;

    /**
     * @var string The item's fascia sconto
     */
    public $fasciaSconto = null;

    /**
     * @var string The item's sconto1
     */
    public $sconto1 = null;

    /**
     * @var string The item's sconto2
     */
    public $sconto2 = null;

    /**
     * @var string The item's Prezzo lordo
     */
    public $prezzoLordo = null;

    /**
     * @var string The item's Fascia listino
     */
    public $fasciaListino = null;

    /**
     * @var string The item's codice listino
     */
    public $codiceListino = null;

    /**
     * @var string The item's category
     */
    public $categoriaArticolo = null;

    /**
     * @var string The item's Prezzo netto
     */
    public $prezzoNetto = null;

    /**
     * @var string The item's fornitore
     */
    public $fornitoreArticolo = null;

    /**
     * @var string Prezzo promozionale (se esiste)
     */
    public $prezzoProm = null;

    /**
     * @var string Descizione promozione
     */
    public $descrProm = null;

    /**
     * @var string Scadenza promozione
     */
    public $scadenzaProm = null;

    /**
     * @var string Disponibilità filiale di Casoria
     */
    public $dispCa = null;

    /**
     * @var string Disponibilità filiale di Caserta
     */
    public $dispCe = null;

    /**
     * @var string Disponibilità filiale di Pozzuoli
     */
    public $dispPo = null;

    /**
     * @var string Disponibilità filiale di totale
     */
    public $dispTot = null;

    /**
     * Sets the object's properties using the values in the supplied array
     *
     * @param assoc The property values
     */
    public function __construct($data = array()) {
        if (isset($data['CodiceArticolo']))
            $this->codiceArticolo = $data['CodiceArticolo'];
        if (isset($data['DescrizioneArticolo']))
            $this->descrizione = $data['DescrizioneArticolo'];
        if (isset($data['CodiceAlternativo1']))
            $this->codForn1 = $data['CodiceAlternativo1'];
        if (isset($data['CodiceAlternativo2']))
            $this->codForn2 = $data['CodiceAlternativo2'];
        if (isset($data['FasciaSconto']))
            $this->fasciaSconto = $data['FasciaSconto'];
        if (isset($data['Sconto1']))
            $this->sconto1 = $data['Sconto1'];
        if (isset($data['Sconto2']))
            $this->sconto2 = $data['Sconto2'];
        if (isset($data['PrezzoLordo']))
            $this->prezzoLordo = str_replace("." , "," ,$data['PrezzoLordo']);
        if (isset($data['FasciaListino']))
            $this->fasciaListino = $data['FasciaListino'];
        if (isset($data['codice']))
            $this->codiceListino = $data['codice'];
        if (isset($data['DESCR']))
            $this->categoriaArticolo = $data['DESCR'];
        if (isset($data['PREZZONETTO']))
            $this->prezzoNetto =  str_replace("." , "," ,$data['PREZZONETTO']);
        if (isset($data['FORNITORE']))
            $this->fornitoreArticolo = $data['FORNITORE'];
        if (isset($data['PrezzoProm']))
            $this->prezzoProm = str_replace("." , "," ,$data['PrezzoProm']);
        if (isset($data['DescrProm']))
            $this->descProm = $data['DescrProm'];
        if (isset($data['ScadenzaProm']))
            $this->scadenzaProm = trim($data['ScadenzaProm']);
        if (isset($data['DispCasoria']))
            $this->dispCa = $data['DispCasoria'];
        if (isset($data['DispCaserta']))
            $this->dispCe = $data['DispCaserta'];
        if (isset($data['DispPozzuoli']))
            $this->dispPo = $data['DispPozzuoli'];
        if (isset($data['DispTotale']))
            $this->dispTot = $data['DispTotale'];
    }

    /**
     * Get item list
     */
    public static function getItemList($searchTerm, $fasciaSconto, $searchOptions) {
        if ($searchTerm != "") {

            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $sql = "SELECT Listini_Norm.CodiceArticolo,
                                     Listini_Norm.DescrizioneArticolo,
                                     Listini_Norm.CodiceAlternativo1,
                                     Listini_Norm.CodiceAlternativo2,
                                     Listini_Norm.FasciaSconto,
                                     Listini_Norm.PREZZONETTO,
                                     Listini_Norm.FORNITORE,
                                     Listini_Prom.PrezzoNetto AS PrezzoProm,
                                     Listini_Prom.DataFine AS ScadenzaProm,
                                     COALESCE(sum(Giacenze.GIACENZA),0) as DispTotale
                                     FROM Listini_Norm 
                                     LEFT JOIN Listini_Prom ON Listini_Norm.CodiceArticolo = Listini_Prom.CodiceArticolo
                                     LEFT JOIN Giacenze ON Listini_Norm.CodiceArticolo = Giacenze.CODART
                                     WHERE (";

            $options = array();

            if (in_array("descrizione", $searchOptions)) {
                $options[] = "Listini_Norm.DescrizioneArticolo like concat('%', :searchTerm, '%')";
            }

            if (in_array("codiceSider", $searchOptions)) {
                $options[] = "Listini_Norm.CodiceArticolo like concat('%', :searchTerm, '%')";
            }

            if (in_array("codiceForn", $searchOptions)) {
                $options[] = "Listini_Norm.CodiceAlternativo1 like concat('%', :searchTerm, '%') OR
                    Listini_Norm.CodiceAlternativo2 like concat('%', :searchTerm, '%')";
            }

            if (count($options) < 1) {
                $options[] = "Listini_Norm.DescrizioneArticolo like concat('%', :searchTerm, '%')";
            }

            if (count($options) > 1) {
                $andOr = "OR";
            } else {
                $andOr = "";
            }

            $sql .= implode(" {$andOr} ", $options) . ") AND Listini_Norm.FasciaSconto = :fasciaSconto
                                                       GROUP BY Listini_Norm.CodiceArticolo
                                                       ORDER BY DispTotale DESC, Listini_Norm.DescrizioneArticolo LIMIT 50";

            $st = $conn->prepare($sql);
            $st->bindValue(":searchTerm", $searchTerm, PDO::PARAM_STR);
            $st->bindValue(":fasciaSconto", $fasciaSconto, PDO::PARAM_STR);
            $st->execute();
            $list = array();

            while ($row = $st->fetch()) {
                $list[] = new Item($row);
            }

            $conn = null;
            return $list;
        }
    }
     
     
     /**
     * Get item details
     */
    public static function getItemById($codiceArticolo, $fasciaSconto) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare("SELECT Listini_Norm.CodiceArticolo,
                                     Listini_Norm.DescrizioneArticolo,
                                     Listini_Norm.CodiceAlternativo1,
                                     Listini_Norm.CodiceAlternativo2,
                                     Listini_Norm.FasciaSconto,
                                     Listini_Norm.Sconto1,
                                     Listini_Norm.Sconto2,
                                     Listini_Norm.PREZZONETTO,
                                     Listini_Norm.PrezzoLordo,
                                     Listini_Norm.FORNITORE,
                                     Listini_Prom.PrezzoNetto AS PrezzoProm,
                                     Listini_Prom.DescrListino AS DescrProm,
                                     Listini_Prom.DataFine AS ScadenzaProm,
                                     sum(if(Giacenze.IDMAG = 27 or Giacenze.IDMAG = 28, Giacenze.GIACENZA, 0)) as DispCasoria,
                                     sum(if(Giacenze.IDMAG = 29, Giacenze.GIACENZA, 0)) as DispCaserta,
                                     sum(if(Giacenze.IDMAG = 30, Giacenze.GIACENZA, 0)) as DispPozzuoli,
                                     COALESCE(sum(Giacenze.GIACENZA),0) as DispTotale
                                     FROM Listini_Norm 
                                     LEFT JOIN Listini_Prom ON Listini_Norm.CodiceArticolo = Listini_Prom.CodiceArticolo
                                     LEFT JOIN Giacenze ON Listini_Norm.CodiceArticolo = Giacenze.CODART
                                     WHERE Listini_Norm.CodiceArticolo = :codiceArticolo
                                     AND Listini_Norm.FasciaSconto = :fasciaSconto");
        $st->bindValue(":codiceArticolo", $codiceArticolo, PDO::PARAM_STR);
        $st->bindValue(":fasciaSconto", $fasciaSconto, PDO::PARAM_STR);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row)
            return new Item($row);
    }
           

}
?>
