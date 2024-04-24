<?php

interface PatientRecord {
    public function getId(): int;
    public function getPatientNumber(): string;
}

class Patient implements PatientRecord {
    private $_id;
    private $pn;
    private $first;
    private $last;
    private $dob;
    private $insurances = [];

    public function __construct($id, $pn, $first = null, $last = null, $dob = null) {
        $this->_id = $id;
        $this->pn = $pn;
        $this->first = $first;
        $this->last = $last;
        $this->dob = $dob;
    }
    

    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return $this->pn;
    }

    public function getFullName(): string {
        return $this->first . ' ' . $this->last;
    }

    public function getInsurances(): array {
        return $this->insurances;
    }

    public function addInsurance(Insurance $insurance) {
        $this->insurances[] = $insurance;
    }

    public function printInsuranceValidity($date) {
        echo "Patient Number, First Last, Insurance name, Is Valid\n";
        foreach ($this->insurances as $insurance) {
            $isValid = $insurance->isValid($date) ? 'Yes' : 'No';
            echo "{$this->pn}, {$this->getFullName()}, {$insurance->getName()}, {$isValid}\n";
        }
    }
}

class Insurance implements PatientRecord {
    private $_id;
    private $patient_id;
    private $iname;
    private $from_date;
    private $to_date;

    public function __construct($id, $patient_id, $iname, $from_date = null, $to_date = null) {
        $this->_id = $id;
        $this->patient_id = $patient_id;
        $this->iname = $iname;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function getPatientNumber(): string {
        return '000000'; // Placeholder value
    }

    public function getName(): string {
        return $this->iname;
    }

    public function isValid($date): bool {
        $dateObj = DateTime::createFromFormat('m-d-y', $date);
        $compareDate = $dateObj->format('Y-m-d');
        $fromDate = $this->from_date;
        $toDate = $this->to_date;

        if ($toDate !== null) {
            return ($compareDate >= $fromDate && $compareDate <= $toDate);
        } else {
            // If to_date is not defined, insurance is effective infinitely
            return $compareDate >= $fromDate;
        }
    }
}

// Test script
$patient1 = new Patient(1, '12345678901', 'Mari', 'Mägi', '1985-05-15');
$patient2 = new Patient(2, '98765432109', 'Peeter', 'Tamm', '1978-10-20');

$insurance1 = new Insurance(1, $patient1->getId(), 'Haigekassa', '2024-01-01', '2025-01-01');
$insurance2 = new Insurance(2, $patient1->getId(), 'Ergo Kindlustus', '2024-01-01', '202-03-01');
$insurance3 = new Insurance(3, $patient2->getId(), 'Compensa', '2010-01-01', '2023-01-01');
$insurance4 = new Insurance(4, $patient2->getId(), 'If Kindlustus', '2024-04-24', '2025-04-24');

$patient1->addInsurance($insurance1);
$patient1->addInsurance($insurance2);
$patient2->addInsurance($insurance3);
$patient2->addInsurance($insurance4);

// Test insurance validity
$today = date('m-d-y');
echo "Patient insurances validity on {$today}:\n";
$patient1->printInsuranceValidity($today);
$patient2->printInsuranceValidity($today);