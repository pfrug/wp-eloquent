<?php
namespace WeDevs\ORM\Eloquent;

use Illuminate\Database\ConnectionResolverInterface;

class Resolver implements ConnectionResolverInterface
{
    /**
     * Get a database connection instance.
     *
     * @param  string $name
     *
     * @return \Illuminate\Database\Connection
     */
    public function connection($name = null)
    {
        $connection = $this->getConnectionInterface($name);
        return Database::instance($connection);
    }

    /**
     * Retrieves a database connection instance.
     * If no connection name is provided, it returns the default connection.
     *
     * @param string|null $name The name of the connection to retrieve (optional).
     * @return \wpdb The database connection instance.
     * @throws \Exception If the specified connection is not configured.
     */
    private function getConnectionInterface($name = null)
    {
        if (is_null($name)) {
            return $this->getDefaultConnection();
        } else {
            global $connections;

            if(!$connections[$name]) throw new \Exception('Error: Connection "'.$name.'" Is not configured');
            return new \wpdb($connections[$name]['username'], $connections[$name]['password'], $connections[$name]['database'], $connections[$name]['host'] );
        }
    }

    /**
     * Get the default connection
     *
     * @return \wpdb
     */
    public function getDefaultConnection()
    {
        global $wpdb;
        return $wpdb;
    }

    /**
     * Set the default connection name.
     *
     * @param  string $name
     *
     * @return void
     */
    public function setDefaultConnection($name)
    {
        // TODO: Implement setDefaultConnection() method.
    }
}