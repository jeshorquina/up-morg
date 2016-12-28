USE upmorg;

CREATE TABLE IF NOT EXISTS `TaskComment` (
    `TaskCommentID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `TaskID` INT UNSIGNED NOT NULL,
    `TaskSubscriberID` INT UNSIGNED NOT NULL,
    `Comment` VARCHAR(511) NOT NULL,
    `Timestamp` TIMESTAMP NOT NULL,
    PRIMARY KEY (`TaskCommentID`)
);

ALTER TABLE `TaskComment`
ADD CONSTRAINT FK_TaskComment_TaskID
FOREIGN KEY (`TaskID`)
REFERENCES Task(`TaskID`);

ALTER TABLE `TaskComment`
ADD CONSTRAINT FK_TaskComment_TaskSubscriberID
FOREIGN KEY (`TaskSubscriberID`)
REFERENCES TaskSubscriber(`TaskSubscriberID`);
