<?php
namespace WeDevs\ORM\Eloquent;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Query\Builder;

/**
 * Model Class
 *
 * @package WeDevs\ERP\Framework
 */
abstract class Model extends Eloquent
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        static::$resolver = new Resolver();
        parent::__construct($attributes);
    }

    /**
     * Get the database connection for the model.
     *
     * @return Database
     */
    public function getConnection()
    {
        return static::resolveConnection($this->connection);
    }

    /**
     * Resolve a connection instance.
     *
     * @param  string  $connection
     * @return Database
     */
    public static function resolveConnection($connection = null)
    {
        return static::$resolver->connection($connection);
    }

    /**
     * Get the table associated with the model.
     *
     * Append the WordPress table prefix with the table name if
     * no table name is provided
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        $table = str_replace( '\\', '', snake_case(str_plural(class_basename($this))));

        return $this->getConnection()->db->prefix . $table ;
    }

    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder() {

        $connection = $this->getConnection();

        return new Builder(
            $connection, $connection->getQueryGrammar(), $connection->getPostProcessor()
        );
    }
}
