<?php
class Etape {
    private int $id;
    private int $recetteId;
    private int $numeroOrdre;
    private string $description;

    public function __construct(int $recetteId = 0, int $numeroOrdre = 0, string $description = "", int $id = 0) {
        $this->recetteId = $recetteId;
        $this->numeroOrdre = $numeroOrdre;
        $this->description = $description;
        $this->id = $id;
    }

    public function setProp(int $recetteId, int $numeroOrdre, string $description, int $id = 0): void {
        $this->recetteId = $recetteId;
        $this->numeroOrdre = $numeroOrdre;
        $this->description = $description;
        $this->id = $id;
    }

    public function getProp(): array {
        return [
            'id' => $this->id,
            'recetteId' => $this->recetteId,
            'numeroOrdre' => $this->numeroOrdre,
            'description' => $this->description,
        ];
    }
}
