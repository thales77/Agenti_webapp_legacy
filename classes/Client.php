<?php

/**
 * Class to retrieve client data from the database
 */
class Client {
// Properties

    /**
     * @var string The client's Ragione Sociale
     */
    public $ragSociale = null;

    /**
     * @var string The client's codice
     */
    public $codice = null;

    /**
     * @var string The client's partita iva
     */
    public $parIva = null;
    
    /**
     * @var string The client's partita iva
     */
    public $categoriaSconto = null;
    
    /**
     * @var string The client's partita iva
     */
    public $noTelefono = null;
    
    /**
     * @var string The client's partita iva
     */
    public $noCell = null;
  
    /**
     * @var string The client's partita iva
     */
    public $noFax = null;
    
    /**
     * @var string The client's partita iva
     */
    public $email = null;
    
    /**
     * @var string The client's partita iva
     */
    public $indirizzo = null;
    
    /**
     * @var string The client's partita iva
     */
    public $cap = null;
    
    /**
     * @var string The client's partita iva
     */
    public $comune = null;
    
    /**
     * @var string The client's partita iva
     */
    public $provincia = null;
    
    /**
     * @var string The client's partita iva
     */
    public $fattCorrente = null;
    
    /**
     * @var string The client's partita iva
     */
    public $fattPrecedente = null;

    /**
     * @var string saldo Professional
     */
    public $saldoProfessional = null;

    /**
     * @var string saldo Service
     */
    public $saldoService = null;
    
     /**
     * @var string stato cliente
     */
    public $stato = null;

    /**
     * Sets the object's properties using the values in the supplied array
     *
     * @param assoc The property values
     */
    public function __construct($data = array()) {
        if (isset($data['DESCR1']))
            $this->ragSociale = $data['DESCR1'];
        if (isset($data['CODICE']))
            $this->codice = $data['CODICE'];
        if (isset($data['PARIVA']))
            $this->parIva = preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['PARIVA']);
        if (isset($data['SCONTO']))
            $this->categoriaSconto = (int) $data['SCONTO'];
        if (isset($data['TEL']))
            $this->noTelefono = preg_replace('/[^0-9]/', '', substr($data['TEL'], 0, 11));
        if (isset($data['Cell']))
            $this->noCell = preg_replace('/[^0-9]/', '', substr($data['Cell'], 0, 11));
        if (isset($data['FAX']))
            $this->noFax = preg_replace('/[^0-9]/', '', substr($data['FAX'], 0, 11));
        if (isset($data['EMAIL']))
            $this->email = preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['EMAIL']);
        if (isset($data['INDIRI']))
            $this->indirizzo = $data['INDIRI'];
        if (isset($data['CAP']))
            $this->cap = preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['CAP']);
        if (isset($data['COMUNE']))
            $this->comune = preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['COMUNE']);
        if (isset($data['PROV']))
            $this->provincia = preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['PROV']);
        if (isset($data['PROGFATIVA']))
            $this->fattCorrente = str_replace(".", ",", ($data['PROGFATIVA']));
        if (isset($data['PROGFATIVAP']))
            $this->fattPrecedente = str_replace(".", ",", ($data['PROGFATIVAP']));
        if (isset($data['SaldoProf']))
            $this->saldoProfessional = str_replace(".", ",", ($data['SaldoProf'] + $data['SaldoBProf'])); //saldo A+B Professional
        if (isset($data['SaldoService']))
            $this->SaldoService = str_replace(".", ",", ($data['SaldoService'] + $data['SaldoBService'])); //saldo A+B Service
        if (isset($data['STATO']))
            $this->stato = (int) $data['STATO'];
    }

    /**
     * Retrieve client list matching the search string ordered by fatturato
     */
    public static function getClientList($searchTerm, $searchOptions) {

        if ($searchTerm != "") {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

            $sql = "SELECT * FROM Clienti WHERE ";

            $options = array();

            if (in_array("ragioneSociale", $searchOptions)) {
                $options[] = "DESCR1 like concat('%', :searchTerm, '%') OR DESCR2 like concat('%', :searchTerm, '%')";
            }
            if (in_array("codiceCliente", $searchOptions)) {
                $options[] = "CODICE like concat('%', :searchTerm, '%')";
            }
            if (in_array("partitaIva", $searchOptions)) {
                $options[] = "PARIVA like concat('%', :searchTerm, '%')";
            }
            if (in_array("comune", $searchOptions)) {
                $options[] = "COMUNE like concat('%', :searchTerm, '%')";
            }
            if (count($options) < 1) {
                $options[] = "DESCR1 like concat('%', :searchTerm, '%') OR DESCR2 like concat('%', :searchTerm, '%')";
            }

            if (count($options) > 1) {
                $andOr = "OR";
            }
            else {
                $andOr = "";
            }
            
            $sql .= implode(" {$andOr} ", $options) . " ORDER BY PROGFATIVA+PROGFATIVAP DESC LIMIT 50";
            $st = $conn->prepare($sql);

            $st->bindValue(":searchTerm", $searchTerm, PDO::PARAM_STR);
            $st->execute();
            $list = array();

            while ($row = $st->fetch()) {
                $list[] = new Client($row);
            }

            $conn = null;
            return json_encode($list);
        }
    }
     /**
     * Get client details
     */
    public static function getClientById($clientId) {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $st = $conn->prepare("SELECT Clienti.DESCR1,
                                     Clienti.CODICE,
                                     Clienti.PARIVA,
                                     Clienti.SCONTO,
                                     Clienti.TEL,
                                     Clienti.Cell,
                                     Clienti.FAX,
                                     Clienti.EMAIL,
                                     Clienti.INDIRI,
                                     Clienti.CAP,
                                     Clienti.COMUNE,
                                     Clienti.PROV,
                                     Clienti.PROGFATIVA,
                                     Clienti.PROGFATIVAP,
                                     Clienti.STATO,
                                     COALESCE(saldicliProfessional.saldo,0) AS SaldoProf,
                                     COALESCE(saldicliService.saldo,0) AS SaldoService,
                                     COALESCE(saldicliProfessional.SaldoX, 0) AS SaldoBProf,
                                     COALESCE(saldicliService.SaldoX,0) AS SaldoBService
                                     FROM Clienti 
                                     LEFT JOIN saldicliProfessional ON Clienti.CODICE = saldicliProfessional.CODICE
                                     LEFT JOIN saldicliService ON saldicliProfessional.PARIVA = saldicliService.PARIVA
                                     WHERE Clienti.CODICE = :clientId");
        $st->bindValue(":clientId", $clientId, PDO::PARAM_STR);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row)
            return new Client($row);
    }
}

?>
