USE upmorg;

CREATE TABLE IF NOT EXISTS `LedgerInput` (
    `LedgerInputID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `BatchMemberID` INT UNSIGNED NOT NULL,
    `InputType` INT UNSIGNED NOT NULL,
    `Amount` INT UNSIGNED NOT NULL,
    `IsVerified` BOOLEAN NOT NULL,
    PRIMARY KEY (`LedgerInputID`)
);

ALTER TABLE `LedgerInput`
ADD CONSTRAINT FK_LedgerInput_BatchMemberID
FOREIGN KEY (`BatchMemberID`)
REFERENCES BatchMember(`BatchMemberID`);
