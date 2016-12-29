USE upmorg;

CREATE TABLE IF NOT EXISTS `TaskSubscriber` (
    `TaskSubscriberID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `TaskID` INT UNSIGNED NOT NULL,
    `BatchMemberID` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`TaskSubscriberID`)
);

ALTER TABLE `TaskSubscriber`
ADD CONSTRAINT FK_TaskSubscriber_TaskID
FOREIGN KEY (`TaskID`)
REFERENCES Task(`TaskID`);

ALTER TABLE `TaskSubscriber`
ADD CONSTRAINT FK_TaskSubscriber_BatchMemberID
FOREIGN KEY (`BatchMemberID`)
REFERENCES BatchMember(`BatchMemberID`);
