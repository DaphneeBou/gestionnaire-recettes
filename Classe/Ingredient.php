<?php
class Ingredient {
    private int $id;
    private string $nom;
    private string $unitePardefaut;

    public function __construct(string $nom = "", string $unitePardefaut = "", int $id = 0) {
        $this->nom = $nom;
        $this->unitePardefaut = $unitePardefaut;
        $this->id = $id;
    }

    public function setProp(string $nom, string $unitePardefaut, int $id = 0): void {
        $this->nom = $nom;
        $this->unitePardefaut = $unitePardefaut;
        $this->id = $id;
    }

    public function getProp(): array {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'unitePardefaut' => $this->unitePardefaut,
        ];
    }
}
?>