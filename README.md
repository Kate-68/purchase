# Purchase

main soubory = indexy jednotlivych class
 - controllers/main.php -> obsahuje rozcestnik pro controllery
 - models/main.php -> obsahuje rozcestnik pro modely
 - views/main.php -> obsahuje rozcestnik pro views

API specifikace
 - GET  /           -- vytahne homepage
 - GET  /login      -- vytahne logovaci stranku
 - POST /login      -- zaloguje uzivatele
 - GET  /register   -- vytahne registracni stranku
 - POST /register   -- zaregistruje noveho uzivatele
 - GET  /spendings  -- stranka prehledu utraty
 - GET  /purchases  -- stranka na formular pridani purchase
 - POST /purchases  -- vytvori novou purchase
 - other            -- not found


```sql
CREATE TABLE IF NOT EXISTS `purchases_user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(255) NULL,
  `user_password` VARCHAR(255) NULL,
  `user_email` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `purchases_purchase` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `purchase_date` DATE NULL,
  `puchase_amount` FLOAT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_purchase_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_purchase_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `purchases_user` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
```

## Specifikace

## Technická dokumentace