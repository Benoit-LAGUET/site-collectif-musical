<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250829145550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, in_setlist BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE song_instrument (song_id INTEGER NOT NULL, instrument_id INTEGER NOT NULL, PRIMARY KEY (song_id, instrument_id), CONSTRAINT FK_8617F3CDA0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8617F3CDCF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8617F3CDA0BDB2F3 ON song_instrument (song_id)');
        $this->addSql('CREATE INDEX IDX_8617F3CDCF11D9C ON song_instrument (instrument_id)');
        $this->addSql('CREATE TABLE vote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER NOT NULL, song_id INTEGER NOT NULL, CONSTRAINT FK_5A1085647597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5A108564A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5A1085647597D3FE ON vote (member_id)');
        $this->addSql('CREATE INDEX IDX_5A108564A0BDB2F3 ON vote (song_id)');
        $this->addSql('CREATE TABLE vote_instrument (vote_id INTEGER NOT NULL, instrument_id INTEGER NOT NULL, PRIMARY KEY (vote_id, instrument_id), CONSTRAINT FK_D7F3132572DCDAFC FOREIGN KEY (vote_id) REFERENCES vote (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D7F31325CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D7F3132572DCDAFC ON vote_instrument (vote_id)');
        $this->addSql('CREATE INDEX IDX_D7F31325CF11D9C ON vote_instrument (instrument_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE song_instrument');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_instrument');
    }
}
