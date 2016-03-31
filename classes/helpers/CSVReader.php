<?php
/**
 * CSVReader implementiert das Iterator-Interface und lässt sich daher mit foreach-Schleifen nutzen.
 * @author Markus Jungbluth
 * 
 */

namespace helpers;

/**
 * Class CSVReader
 * @package helpers
 *
 * Einfacher CSV Leser
 */
class CSVReader implements \Iterator {
    
    /**
     * Dateiname
     * @var string
     */
    private $filename;
    /**
     * Enthält den File-Pointer/Handle auf die Datei
     * @var fp 
     */
    private $handle;
    
    /**
     * Der verwendete Delimiter
     * @var string
     */
    private $delimiter;
    /**
     * Zeilenposition
     * @var int 
     */
    private $rowCounter;
    /**
     * Inhalt der Zeile
     * @var array
     */
    private $currentLn;
    
    /**
     * Erstellt ein neues CSVReader-Objekt.
     * Mit Instanziierung der Klasse wird bereits die erste Zeile gelesen.
     * @param string $filename Dateiname der CSV-Datei
     * @param string $delimiter Verwendeter Delimiter (Standard: ",")
     * @throws Exception
     */
    public function __construct($filename, $delimiter = ",") {
        $this->row = -1;
        $this->delimiter = $delimiter;
        $this->filename = $filename;
        $this->currentLn = NULL;
        $this->handle = @fopen($this->filename, "r");
        if ($this->handle === FALSE) throw new Exception ("Datei konnte nicht geöffnet werden.");
        $this->readLn();
    }
    
    /**
     * Liest eine neue Zeile aus der CSV-Datei
     */
    private function readLn() {
        $data = fgetcsv($this->handle,0,$this->delimiter);
        $this->rowCounter++;
        $this->currentLn = $data;
    }
    
    /**
     * Destruktor schließt den Dateizeiger auf die CSV-Datei
     */
    public function __destruct() {
        fclose($this->handle);
    }

    /**
     * Gibt den aktuellen Datensatz aus.
     * @return type
     * @throws Exception
     */
    public function current() {
        if(!$this->valid()) {
            throw new Exception("Ende der Datei erreicht. Auslesen nicht möglich.");
        }
        return $this->currentLn;
    }
    /**
     * Gibt die aktuelle Position in der Datei aus.
     * @return int
     */
    public function key() {
        return $this->rowCounter;
    }
    /**
     * Springt zum nächsten Eintrag der Datei. 
     * Ist das Ende der Datei bereits erreicht und wird erneut next() aufgerufen
     * wird einer Exception geworfen.
     * @return type
     * @throws Exception
     */
    public function next() {
        if ($this->valid()) { 
            $this->readLn();
            return;
        }
        throw new Exception("Ende der Datei erreicht.");
    }
    /**
     * Setzt den Dateizeiger zurück auf den Anfang der Datei.
     */
    public function rewind() {
        $this->rowCounter = -1;
        $this->currentLn = NULL;
        rewind($this->handle);
        $this->readLn();
    }
    /**
     * Prüft ob der Dateizeiger auf einen gültigen Datensatz (!= EOF) zeigt.
     * @return boolean
     */
    public function valid() {
        if(feof($this->handle)) { 
            return false;
        }    
        return true;
    }

}

