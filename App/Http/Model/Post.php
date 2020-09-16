<?php

namespace App\Http\Model;

use App\Core\Model;
use App\Helpers\DebugPDO;

class Post extends Model
{
    protected $table_name = "books";
    protected $fields = ['id', 'title', 'author', 'link'];

    public function getAll()
    {
        $sql = "SELECT " . implode(',', $this->fields) . " FROM " . $this->table_name;
        $query = $this->db->prepare($sql);
        $query->execute();

        if (DEBUG) {
            echo "<div style='font-size: 1rem; display: inline-block; background-color: #3a91c7; border: 1px solid #ddd; min-width: 230px; padding: 1rem 1rem 1rem 1rem; font-family: monospace;'>";
            echo "<span style='font-weight: bold; color: #222222; font-size: 2rem; width: 100%'>PDO Debug</span>" . "<br />";
            echo "<span style='font-weight: bold; color: #121212'>SQL Debug: </span>" . DebugPDO::debugPDO($sql, null) . "<br />";
            echo "</div>";
        }

        return $query->fetchAll();
    }
}

