<?php
class Recette {
    private int $id;
    private string $titre;
    private string $description;
    private int $tempsPreparation;
    private int $portions;
    private int $categorieId;

    public function __construct(string $titre = "", int $categorieId = 0, int $id = 0) {
        $this->titre = $titre;
        $this->categorieId = $categorieId;
        $this->id = $id;
    }

    public function setProp(string $titre, string $description, int $tempsPreparation, int $portions, int $categorieId, int $id = 0): void {
        $this->titre = $titre;
        $this->description = $description;
        $this->tempsPreparation = $tempsPreparation;
        $this->portions = $portions;
        $this->categorieId = $categorieId;
        $this->id = $id;
    }

    public function getProp(): array {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'tempsPreparation' => $this->tempsPreparation,
            'portions' => $this->portions,
            'categorieId' => $this->categorieId,
        ];
    }

    public function getCard(): string {
        $return = "<h2>".$this->titre."</h2>";
        $return .= "<p class='info'><strong>Description : </strong>".$this->description."</p>";
        $return .= "<p class='info'><strong>Temps de preparation : </strong>".$this->tempsPreparation." min</p>";
        $return .= "<p class='info'><strong>Portions : </strong>".$this->portions."</p>";
        return $return;
    }
}
?>