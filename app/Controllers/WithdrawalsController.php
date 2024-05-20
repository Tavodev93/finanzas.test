<?php

namespace App\Controllers;

use Database\PDO\Connection;

class WithdrawalsController {

    private $connection;

    public function __construct() {
        $this->connection = Connection::getInstance()->get_database_instance();
    }

    public function index() {

        $stmt = $this->connection->prepare("SELECT * FROM withdrawals");
        $stmt->execute();

        $results = $stmt->fetchAll();

        foreach ($results as $results) {
            echo "Gastaste " . $results["amount"] . " USD en: " . $results ["description"] . "\n";
        }

    }

    public function create() {}

    public function store($data) {

        $stmt = $this->connection->prepare("INSERT INTO withdrawals (payment_method, type, date, amount, description) VALUES (:payment_method, :type, :date, :amount, :description)");

        $stmt->bindValue(":payment_method", $data["payment_method"]);
        $stmt->bindValue(":type", $data["type"]);
        $stmt->bindValue(":date", $data["date"]);
        $stmt->bindValue(":amount", $data["amount"]);
        $stmt->bindValue(":description", $data["description"]);


        $data["description"] = "Compre un celular para mi esposa";

        $stmt->execute();
    }

    public function show($id) {

        $stmt = $this->connection->prepare("SELECT * FROM withdrawals WHERE id=:id");
        $stmt->execute([
            ":id" => $id
        ]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        echo "El registro con id $id dice que te gastaste {$result['amount']} USD en {$result['description']}";
    }

    public function edit() {}

    public function update($date, $id) {

        $stmt = $this->connection->prepare("UPDATE incomes SET
        payment_method = :payment_method,
        type = :type,
        date = :date,
        amount = :amount,
        description = :description
    WHERE id=:id;");

    $stmt->execute([
        ":id" => $id,
        ":payment_method" => $date["payment_method"],
        ":type" => $date["type"],
        ":date" => $date["date"],
        ":amount" => $date["amount"],
        ":description" => $date["description"],
    ]);
}

    public function destroy($id) {
        $delete = $this->connection->prepare("DELETE FROM withdrawals WHERE id = :id");

        $delete->execute([
            ":id" => $id
        ]);
    }

}

/*

index -  Muestra una lista de este recurso.
create - Muestra un formulario para crear un nuevo recurso.
store - Guarda un nuevo recurso en la base de datos.
show - Muestra un único recurso especificado.
edit - Muestra el formulario para editar un recurso.
update -  Actualiza un recurso específico en la base de datos.
destroy - Elimina un recurso específico de la base de datos.

*/