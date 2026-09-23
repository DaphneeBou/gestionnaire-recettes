<?php
class Categorie {
    private int $id;
    private string $nom;

    public function __construct(string $nom = "", int $id = 0) {
        $this->nom = $nom;
        $this->id = $id;
    }

    public function setProp(string $nom, int $id = 0): void {
        $this->nom = $nom;
        $this->id = $id;
    }

    public function getProp(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }
}
?>