DROP DATABASE if EXISTS RoRDB;
CREATE DATABASE if NOT EXISTS RoRDB;
USE RoRDB;

CREATE TABLE ror_users (
        summonerName VARCHAR(20) PRIMARY KEY,
        total_wins INT,
        totalGames INT,
        longest_expedition INT,
        most_consecutive_expedition_wins INT,
        expedition_wins INT,
        expedition_games INT
);

CREATE TABLE ror_cards (
        cardID VARCHAR(20) PRIMARY KEY,
        cardName VARCHAR(20),
        cardType VARCHAR(20),
        gamesPlayed INT,
        gamesWon INT,
        expeditionGames INT,
        expeditionWins INT,
        win_rate DECIMAL(5, 2),
        play_rate DECIMAL(5, 2)
);

CREATE TABLE ror_decks (
        deckString VARCHAR(80) PRIMARY KEY,
        wins INT,
        totalGames INT,
        win_rate DECIMAL(5, 2),
        play_rate DECIMAL(5, 2)
);    

CREATE TABLE ror_records (
        recordName VARCHAR(40) PRIMARY KEY
);


INSERT INTO ror_records VALUES
('Total Wins'),
('Longest Expedition'),
('Most Consecutive Expedition Wins');
