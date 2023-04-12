<?php

namespace App\Controllers;

use App\Services\Database;
use App\Services\Router;

class Create
{
    public function content()
    {

        $database = new Database;

        $pdo = $database::start();

        // categories
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;
SQL;
        $pdo->exec($sql);

// products
        $sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `products` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    `category_id` INT NOT NULL, 
    `price` DECIMAL(10,2) NOT NULL , 
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    `description` TEXT NOT NULL , 
    
    PRIMARY KEY (`id`)) 
    ENGINE = InnoDB;
SQL;
        $pdo->exec($sql);

// add references with table categories
        $sql = <<<'SQL'
ALTER TABLE `products` 
    ADD FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`);
SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
INSERT INTO `categories` (`id`, `name`) VALUES 
    (NULL, 'Vegetables'), 
    (NULL, 'Fruits'),      
    (NULL, 'Dairy'),     
    (NULL, 'Grocery'),                                            
    (NULL, 'Meat');
SQL;
        $pdo->exec($sql);

        $sql = <<<'SQL'
INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `date`, `description`) VALUES 
    (NULL, 'Potato', '1', '0.54', CURRENT_TIMESTAMP, 'The potato is a starchy food, a tuber of the plant Solanum tuberosum and is a root vegetable native to the Americas. The plant is a perennial in the nightshade family Solanaceae.'),
    (NULL, 'Tomato', '1', '2.45', CURRENT_TIMESTAMP, 'The tomato (/təmeɪtoʊ/ or /təmɑːtoʊ/) is the edible berry of the plant Solanum lycopersicum, commonly known as the tomato plant. The species originated in western South America, Mexico, and Central America. The Mexican Nahuatl word tomatl gave rise to the Spanish word tomate, from which the English word tomato derived. Its domestication and use as a cultivated food may have originated with the indigenous peoples of Mexico. The Aztecs used tomatoes in their cooking at the time of the Spanish conquest of the Aztec Empire, and after the Spanish encountered the tomato for the first time after their contact with the Aztecs, they brought the plant to Europe, in a widespread transfer of plants known as the Columbian exchange. From there, the tomato was introduced to other parts of the European-colonized world during the 16th century.'),
    (NULL, 'Cucumber', '1', '1.79', CURRENT_TIMESTAMP, 'The cucumber (Cucumis sativus) is a widely-cultivated creeping vine plant in the family Cucurbitaceae that bears cylindrical to spherical fruits, which are used as culinary vegetables. Considered an annual plant, there are three main types of cucumber—slicing, pickling, and seedless—within which several cultivars have been created. The cucumber originates from Himalaya to China (Yunnan, Guizhou, Guangxi) and N. Thailand, but now grows on most continents, and many different types of cucumber are grown commercially and traded on the global market. In North America, the term wild cucumber refers to plants in the genera Echinocystis and Marah, though the two are not closely related.'),    
    (NULL, 'Cabbage', '1', '0.68', CURRENT_TIMESTAMP, 'Cabbage, comprising several cultivars of Brassica oleracea, is a leafy green, red (purple), or white (pale green) biennial plant grown as an annual vegetable crop for its dense-leaved heads. It is descended from the wild cabbage (B. oleracea var. oleracea), and belongs to the "cole crops" or brassicas, meaning it is closely related to broccoli and cauliflower (var. botrytis); Brussels sprouts (var. gemmifera); and Savoy cabbage (var. sabauda).'),
    (NULL, 'Apple', '2', '0.54', CURRENT_TIMESTAMP, 'Multi-seeded non-opening fruit of plants of the subfamily Apple-tree families Pink (apple, pear, cotoneaster, hawthorn, medlar, quince, mountain ash). In the narrow sense - the fruit of the domestic apple tree.'),
    (NULL, 'Orange', '2', '1.22', CURRENT_TIMESTAMP, 'Orange (lat. Cītrus × sinēnsis) - a fruit tree; a species of the genus Citrus of the Rutaceae family, as well as the fruit of this tree. Orange is the most common citrus crop in all tropical and subtropical regions of the world. There is an assumption about the origin as a hybrid of mandarin (Citrus reticulata) and pomelo (Citrus maxima). The plant was cultivated in China as early as 2.5 thousand years BC. e. The earliest mention of the orange is in a Chinese source from 314 BC. e[4]. It was brought to Europe by Portuguese sailors. After this, the fashion for growing orange trees quickly spread; for this, they began to build special glass structures called greenhouses (from French orange - “orange”). Orange trees grow all along the Mediterranean coast (and also in Central America)'),
    (NULL, 'Banana', '2', '2.18', CURRENT_TIMESTAMP, 'A banana is an elongated, edible fruit – botanically a berry – produced by several kinds of large herbaceous flowering plants in the genus Musa. In some countries, bananas used for cooking may be called "plantains", distinguishing them from dessert bananas. The fruit is variable in size, color, and firmness, but is usually elongated and curved, with soft flesh rich in starch covered with a rind, which may be green, yellow, red, purple, or brown when ripe. The fruits grow upward in clusters near the top of the plant. Almost all modern edible seedless (parthenocarp) bananas come from two wild species – Musa acuminata and Musa balbisiana. The scientific names of most cultivated bananas are Musa acuminata, Musa balbisiana, and Musa × paradisiaca for the hybrid Musa acuminata × M. balbisiana, depending on their genomic constitution. The old scientific name for this hybrid, Musa sapientum, is no longer used.'),
    (NULL, 'Lemon', '2', '1.22', CURRENT_TIMESTAMP, 'The lemon (Citrus limon) is a species of small evergreen trees in the flowering plant family Rutaceae, native to Asia, primarily Northeast India (Assam), Northern Myanmar or China. The tree ellipsoidal yellow fruit is used for culinary and non-culinary purposes throughout the world, primarily for its juice, which has both culinary and cleaning uses.[2] The pulp and rind are also used in cooking and baking. The juice of the lemon is about 5% to 6% citric acid, with a pH of around 2.2, giving it a sour taste. The distinctive sour taste of lemon juice makes it a key ingredient in drinks and foods such as lemonade and lemon meringue pie.'),
    (NULL, 'Milk', '3', '1.09', CURRENT_TIMESTAMP, 'Milk is a white liquid food produced by the mammary glands of mammals. It is the primary source of nutrition for young mammals (including breastfed human infants) before they are able to digest solid food. Immune factors and immune-modulating components in milk contribute to milk immunity. Early-lactation milk, which is called colostrum, contains antibodies that strengthen the immune system, and thus reduces the risk of many diseases. Milk contains many nutrients, including protein and lactose.'),
    (NULL, 'Cottage cheese', '3', '1.36', CURRENT_TIMESTAMP, 'Cottage cheese is a curdled milk product with a mild flavor and a creamy, heterogenous, soupy texture. It is made from skimmed milk by draining curds, but retaining some of the whey and keeping the curds loose. An important step in the manufacturing process distinguishing cottage cheese from other fresh cheeses is the adding of a "dressing" to the curd grains, usually cream, which is largely responsible for the taste of the product. Cottage cheese is not aged.'),
    (NULL, 'Cheese', '3', '10.06', CURRENT_TIMESTAMP, 'Cheese is a dairy product produced in wide ranges of flavors, textures, and forms by coagulation of the milk protein casein. It comprises proteins and fat from milk (usually the milk of cows, buffalo, goats, or sheep). During production, milk is usually acidified and either the enzymes of rennet or bacterial enzymes with similar activity are added to cause the casein to coagulate. The solid curds are then separated from the liquid whey and pressed into finished cheese. Some cheeses have aromatic molds on the rind, the outer layer, or throughout.'),
    (NULL, 'Sour cream', '3', '0.82', CURRENT_TIMESTAMP, 'Sour cream (in North American English, Australian English and New Zealand English) or soured cream (British English) is a dairy product obtained by fermenting regular cream with certain kinds of lactic acid bacteria. The bacterial culture, which is introduced either deliberately or naturally, sours and thickens the cream. Its name comes from the production of lactic acid by bacterial fermentation, which is called souring. Crème fraîche is one type of sour cream with a high fat content and less sour taste.'),
    (NULL, 'Rice', '4', '1.09', CURRENT_TIMESTAMP, 'Rice is the seed of the grass species Oryza sativa (Asian rice) or less commonly O. glaberrima (African rice). The name wild rice is usually used for species of the genera Zizania and Porteresia, both wild and domesticated, although the term may also be used for primitive or uncultivated varieties of Oryza.'),
    (NULL, 'Peas', '4', '0.82', CURRENT_TIMESTAMP, 'The pea is most commonly the small spherical seed or the seed-pod of the flowering plant species Pisum sativum. Each pod contains several peas, which can be green or yellow. Botanically, pea pods are fruit, since they contain seeds and develop from the ovary of a (pea) flower. The name is also used to describe other edible seeds from the Fabaceae such as the pigeon pea (Cajanus cajan), the cowpea (Vigna unguiculata), and the seeds from several species of Lathyrus.'),
    (NULL, 'Millet', '4', '1.09', CURRENT_TIMESTAMP, 'Millets (/ˈmɪlɪts/) are a highly varied group of small-seeded grasses, widely grown around the world as cereal crops or grains for fodder and human food. Most species generally referred to as millets belong to the tribe Paniceae, but some millets also belong to various other taxa.'),
    (NULL, 'Pork', '5', '4.08', CURRENT_TIMESTAMP, 'Pork is the culinary name for the meat of the pig (Sus domesticus). It is the most commonly consumed meat worldwide, with evidence of pig husbandry dating back to 5000 BCE. Pork is eaten both freshly cooked and preserved; curing extends the shelf life of pork products. Ham, gammon, bacon, and sausage are examples of preserved pork. Charcuterie is the branch of cooking devoted to prepared meat products, many from pork.'),
    (NULL, 'Beef', '5', '5.44', CURRENT_TIMESTAMP, 'Beef is the culinary name for meat from cattle (Bos taurus). In prehistoric times, humankind hunted aurochs and later domesticated them. Since that time, numerous breeds of cattle have been bred specifically for the quality or quantity of their meat. Today, beef is the third most widely consumed meat in the world, after pork and poultry. As of 2018, the United States, Brazil, and China were the largest producers of beef.'),
    (NULL, 'Mutton', '5', '6.81', CURRENT_TIMESTAMP, 'Lamb, hogget, and mutton, generically sheep meat, are the meat of domestic sheep, Ovis aries. A sheep in its first year is a lamb and its meat is also lamb. The meat from sheep in their second year is hogget. Older sheep meat is mutton. Generally, "hogget" and "sheep meat" are not used by consumers outside Norway, New Zealand, South Africa, Scotland, and Australia. Hogget has become more common in England, particularly in the North (Lancashire and Yorkshire) often in association with rare breed and organic farming.'),
    (NULL, 'Chicken', '5', '4.08', CURRENT_TIMESTAMP, 'Chicken can be prepared in a vast range of ways, including baking, grilling, barbecuing, frying, and boiling. Since the latter half of the 20th century, prepared chicken has become a staple of fast food. Chicken is sometimes cited as being more healthful than red meat, with lower concentrations of cholesterol and saturated fat.'),                                                                                        
    (NULL, 'Buckwheat', '4', '1.63', CURRENT_TIMESTAMP, 'Buckwheat (Fagopyrum esculentum), or common buckwheat, is a flowering plant in the knotweed family Polygonaceae cultivated for its grain-like seeds and as a cover crop. The name \"buckwheat\" is used for several other species, such as Fagopyrum tataricum, a domesticated food plant raised in Asia.') 
SQL;
        $pdo->exec($sql);
        $_GET['check'] = true;
        Router::redirect('home');
    }
}
