<?php

namespace App\Controllers;

use Database\PDO\Connection;

class IncomesController {

    private $connection;

    public function __construct() {
        $this->connection = Connection::getInstance()->get_database_instance();
    }

    public function index() {

    $stmt = $this->connection->prepare("SELECT * FROM incomes");
    $stmt->execute();

    $results = $stmt->fetchAll();

    require("../resources/views/incomes/index.php");
    }

    public function create() {
        require("../resources/views/incomes/create.php");
    }

    public function store($data) {

        $stmt = $this->connection->prepare("INSERT INTO incomes (payment_method, type, date, amount, description) VALUES (:payment_method, :type, :date, :amount, :description);");

        $stmt->bindValue(":payment_method", $data["payment_method"]);
        $stmt->bindValue(":type", $data["type"]);
        $stmt->bindValue(":date", $data["date"]);
        $stmt->bindValue(":amount", $data["amount"]);
        $stmt->bindValue(":description", $data["description"]);

        $stmt->execute();

        header("location: incomes");

    }

    public function show($id) {

        $stmt = $this->connection->prepare("SELECT * FROM incomes WHERE id=:id");
        $stmt->execute([
            ":id" => $id
        ]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        echo "El registro con id $id dice que te ingreso {$result['amount']} USD en {$result['description']}";
    }

    public function edit() {}

    public function update($data, $id) {

        $stmt = $this->connection->prepare("UPDATE incomes SET
            payment_method = :payment_method,
            type = :type,
            date = :date,
            amount = :amount,
            description = :description
        WHERE id=:id;");

        $stmt->execute([
            ":id" => $id,
            ":payment_method" => $data["payment_method"],
            ":type" => $data["type"],
            ":date" => $data["date"],
            ":amount" => $data["amount"],
            ":description" => $data["description"],
        ]);

    }

    public function destroy($id) {

        $stmt = $this->connection->prepare("DELETE FROM incomes WHERE id = :id");
        $stmt->execute([
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