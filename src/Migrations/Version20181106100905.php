<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181106100905 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_24CC0DF229A5EC27');
        $this->addSql('DROP INDEX IDX_24CC0DF28D93D649');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, produit, user, quantite FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produit INTEGER DEFAULT NULL, user INTEGER DEFAULT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_24CC0DF229A5EC27 FOREIGN KEY (produit) REFERENCES produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_24CC0DF28D93D649 FOREIGN KEY (user) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, produit, user, quantite) SELECT id, produit, user, quantite FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF229A5EC27 ON panier (produit)');
        $this->addSql('CREATE INDEX IDX_24CC0DF28D93D649 ON panier (user)');
        $this->addSql('DROP INDEX IDX_3170B74B29A5EC27');
        $this->addSql('DROP INDEX IDX_3170B74B6EEAA67D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ligne_commande AS SELECT id, commande, produit, quantite FROM ligne_commande');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('CREATE TABLE ligne_commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commande INTEGER DEFAULT NULL, produit INTEGER DEFAULT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_3170B74B6EEAA67D FOREIGN KEY (commande) REFERENCES commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3170B74B29A5EC27 FOREIGN KEY (produit) REFERENCES produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ligne_commande (id, commande, produit, quantite) SELECT id, commande, produit, quantite FROM __temp__ligne_commande');
        $this->addSql('DROP TABLE __temp__ligne_commande');
        $this->addSql('CREATE INDEX IDX_3170B74B29A5EC27 ON ligne_commande (produit)');
        $this->addSql('CREATE INDEX IDX_3170B74B6EEAA67D ON ligne_commande (commande)');
        $this->addSql('DROP INDEX IDX_BE2DDF8C3CFC5900');
        $this->addSql('CREATE TEMPORARY TABLE __temp__produits AS SELECT id, nom, prix, photo, disponible, stock, typeProduit FROM produits');
        $this->addSql('DROP TABLE produits');
        $this->addSql('CREATE TABLE produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prix NUMERIC(8, 2) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL COLLATE BINARY, disponible BOOLEAN DEFAULT NULL, stock INTEGER DEFAULT NULL, typeProduit INTEGER DEFAULT NULL, CONSTRAINT FK_BE2DDF8C3CFC5900 FOREIGN KEY (typeProduit) REFERENCES typeProduits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO produits (id, nom, prix, photo, disponible, stock, typeProduit) SELECT id, nom, prix, photo, disponible, stock, typeProduit FROM __temp__produits');
        $this->addSql('DROP TABLE __temp__produits');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C3CFC5900 ON produits (typeProduit)');
        $this->addSql('DROP INDEX IDX_6EEAA67D8D93D649');
        $this->addSql('DROP INDEX IDX_6EEAA67D55CAF762');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, user, etat, date FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user INTEGER DEFAULT NULL, etat INTEGER DEFAULT NULL, date DATE DEFAULT NULL, CONSTRAINT FK_6EEAA67D8D93D649 FOREIGN KEY (user) REFERENCES app_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6EEAA67D55CAF762 FOREIGN KEY (etat) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commande (id, user, etat, date) SELECT id, user, etat, date FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8D93D649 ON commande (user)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D55CAF762 ON commande (etat)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_6EEAA67D8D93D649');
        $this->addSql('DROP INDEX IDX_6EEAA67D55CAF762');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commande AS SELECT id, user, etat, date FROM commande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('CREATE TABLE commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user INTEGER DEFAULT NULL, etat INTEGER DEFAULT NULL, date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO commande (id, user, etat, date) SELECT id, user, etat, date FROM __temp__commande');
        $this->addSql('DROP TABLE __temp__commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8D93D649 ON commande (user)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D55CAF762 ON commande (etat)');
        $this->addSql('DROP INDEX IDX_3170B74B6EEAA67D');
        $this->addSql('DROP INDEX IDX_3170B74B29A5EC27');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ligne_commande AS SELECT id, commande, produit, quantite FROM ligne_commande');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('CREATE TABLE ligne_commande (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, commande INTEGER DEFAULT NULL, produit INTEGER DEFAULT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO ligne_commande (id, commande, produit, quantite) SELECT id, commande, produit, quantite FROM __temp__ligne_commande');
        $this->addSql('DROP TABLE __temp__ligne_commande');
        $this->addSql('CREATE INDEX IDX_3170B74B6EEAA67D ON ligne_commande (commande)');
        $this->addSql('CREATE INDEX IDX_3170B74B29A5EC27 ON ligne_commande (produit)');
        $this->addSql('DROP INDEX IDX_24CC0DF229A5EC27');
        $this->addSql('DROP INDEX IDX_24CC0DF28D93D649');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, produit, user, quantite FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, produit INTEGER DEFAULT NULL, user INTEGER DEFAULT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO panier (id, produit, user, quantite) SELECT id, produit, user, quantite FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_24CC0DF229A5EC27 ON panier (produit)');
        $this->addSql('CREATE INDEX IDX_24CC0DF28D93D649 ON panier (user)');
        $this->addSql('DROP INDEX IDX_BE2DDF8C3CFC5900');
        $this->addSql('CREATE TEMPORARY TABLE __temp__produits AS SELECT id, nom, prix, photo, disponible, stock, typeProduit FROM produits');
        $this->addSql('DROP TABLE produits');
        $this->addSql('CREATE TABLE produits (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix NUMERIC(8, 2) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, disponible BOOLEAN DEFAULT NULL, stock INTEGER DEFAULT NULL, typeProduit INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO produits (id, nom, prix, photo, disponible, stock, typeProduit) SELECT id, nom, prix, photo, disponible, stock, typeProduit FROM __temp__produits');
        $this->addSql('DROP TABLE __temp__produits');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C3CFC5900 ON produits (typeProduit)');
    }
}
