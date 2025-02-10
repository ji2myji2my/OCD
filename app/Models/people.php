<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class people extends Model
{

    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth'
    ];


    public function children()
    {
        return $this->belongsToMany(
            self::class, 
            'person_parent',
            'parent_id',
            'child_id'
        );
    }


    public function parents()
    {
        return $this->belongsToMany(
            self::class,
            'person_parent',
            'child_id',
            'parent_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    
    public function getDegreeWith($target_person_id)
    {
        $startId = $this->id;

        // La requête SQL récursive
        $sql = "
            WITH RECURSIVE relation_path AS (
                -- Point de départ : on commence par la personne courante
                SELECT id, 0 AS degree, CAST(id AS CHAR(200)) AS path
                FROM (SELECT ? AS id) AS start
                UNION ALL
                -- Pour chaque étape, on récupère les voisins qui ne sont pas déjà dans le chemin
                SELECT 
                    CASE 
                        WHEN pp.parent_id = rp.id THEN pp.child_id 
                        ELSE pp.parent_id 
                    END AS id,
                    rp.degree + 1 AS degree,
                    CONCAT(rp.path, ',', CASE WHEN pp.parent_id = rp.id THEN pp.child_id ELSE pp.parent_id END) AS path
                FROM relation_path rp
                JOIN person_parent pp 
                  ON (pp.parent_id = rp.id OR pp.child_id = rp.id)
                WHERE rp.degree < 25
                  AND FIND_IN_SET(
                        CASE WHEN pp.parent_id = rp.id THEN pp.child_id ELSE pp.parent_id END,
                        rp.path
                      ) = 0
            )
            SELECT degree, path 
            FROM relation_path 
            WHERE id = ? 
            ORDER BY degree 
            LIMIT 1
        ";

        // Exécute la requête avec deux paramètres : le point de départ et la personne cible
        $result = DB::select($sql, [$startId, $target_person_id]);

        // Si aucun résultat n'est trouvé (aucun chemin de degré <= 25), renvoyer false
        if (empty($result)) {
            return false;
        }

        // Sinon, renvoyer l'objet résultat (contenant degree et path)
        return $result[0];
    }
}
