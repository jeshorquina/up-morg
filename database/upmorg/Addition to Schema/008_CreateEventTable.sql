USE upmorg;

CREATE TABLE IF NOT EXISTS `Event` (
    `EventID` INT UNSIGNED NOT NULL,
    `EventOwner` INT UNSIGNED NOT NULL,
    `EventName` VARCHAR(50) NOT NULL,
    `EventDescription` VARCHAR(511) NOT NULL,
    `EventDate` DATE NOT NULL,
    `EventTime` TIME NOT NULL,
    `Timestamp` TIMESTAMP NOT NULL,
    `IsPublic` BOOLEAN NOT NULL,
    PRIMARY KEY (`EventID`)
);

ALTER TABLE `Event`
ADD CONSTRAINT FK_Event_EventOwner
FOREIGN KEY (`EventOwner`)
REFERENCES BatchMember(`BatchMemberID`);
