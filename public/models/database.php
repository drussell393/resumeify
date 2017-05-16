<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Database model, handles all interaction with the database
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to the MIT License found in the 'LICENSE'
 * file in the main directory of this repository.
 *
 * @author Dave Russell Jr <dave@createazure.com>
 * @copyright 2017 Dave Russell Jr
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @version 1.0.0
 * @link https://github.com/drussell393/resumeify
 * @since File available since Release 1.0.0
 */

class DatabaseModel
{
    /**
     * Connects to the database using pre-existing $config variable from init
     *
     * @access private
     * @since Method available since Release 1.0.0
     */
    private function connect()
    {
        global $config, $conn;
        if (!isset($conn))
        {
            try
            {
                $conn = new PDO('mysql:host=' . $config['mysql_hostname'] . ';dbname=' . $config['mysql_database'] . ';', $config['mysql_user'], $config['mysql_password']);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e)
            {
                error_log($e->getMessage());
                print 'We were unable to connect to the database. Please check your error logs.';
                die();
            }
        }
    }
    /**
     * Pulls in personal details from the database
     *
     * This function can either pull in all personal details, or pull in only a specific field name.
     *
     * @param string $field_name value of 'field_name' column in db
     * @return array or string (MySQL results)
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function getPersonalDetails($field_name = NULL)
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        if (is_null($field_name))
        {
            $query = 'SELECT field_name, value, icon, priority
                      FROM personal_details
                      ORDER BY priority';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute())
            {
                return $sth->fetchAll();
            }
            else
            {
                return 'No personal details found in the database';
            }
        }
        else
        {
            $query = 'SELECT field_name, value, icon, priority
                      FROM personal_details
                      WHERE field_name = :field_name';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(':field_name' => $field_name)))
            {
                return $sth->fetch();
            }
            else
            {
                return 'Sorry, there was no database entry for field name: ' . $field_name;
            }
        }
    }
    /**
     * getSkillCategories() gets all skill categories in the database
     *
     * @return array of skill categories from db table 'skills_categories'
     * @access public
     * @since Method avalable since Release 1.0.0
     */
    public function getSkillCategories()
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        $query = 'SELECT id, category_name
                  FROM skills_categories';
        $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute())
        {
            return $sth->fetchAll();
        }
        else
        {
            return 'There\'s no skill categories.';
        }
    }
    /**
     * Pulls in 'skills' from the database
     *
     * The getSkills() function allows pulling in the "skills" from the database
     * in three different ways:
     *
     *  + by skill name (database column field_name)
     *  + by skill category ID (separate database table from the 'skills' table,
     *    pulled in with 'RIGHT JOIN' on the 'category' column of the 'skills' table
     *  + with no options (ie. nothing passed, $skill_name and $skill_category become NULL)
     *    everything is pulled in (all skills in db)
     *
     * @param string $skill_name the name of the skill to be pulled in (optional)
     * @param int $skill_category the category ID of the skill category, pulling in all skills in that category (optional)
     * @return array the result from the MySQL database (ie. all the skills that matched the params or all the skills)
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function getSkills($skill_name = NULL, $skill_category = NULL)
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        if (is_null($skill_name) && is_null($skill_category))
        {
            $query = 'SELECT field_name, experience, experience_level, icon, skills_categories.category_name
                      FROM skills
                      RIGHT JOIN skills_categories
                      ON skills.category = skills_categories.id';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute())
            {
                return $sth->fetchAll();
            }
            else
            {
                return 'Oops, no skills found.';
            }
        }
        else if (is_null($skill_name) && !is_null($skill_category))
        {
            $query = 'SELECT field_name, experience, experience_level, icon, skills_categories.category_name
                      FROM skills
                      RIGHT JOIN skills_categories
                      ON skills.category = skills_categories.id
                      WHERE skills.category = :skill_category';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(':skill_category' => $skill_category)))
            {
                return $sth->fetchAll();
            }
            else
            {
                return 'Oops, no skills in this category.';
            }
        }
        else if (!is_null($skill_name) && is_null($skill_category))
        {
            $query = 'SELECT field_name, experience, experience_level, icon, skills_categories.category_name
                      FROM skills
                      RIGHT JOIN skills_categories
                      ON skills.category = skills_categories.id
                      WHERE skills.field_name = :skill_name';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(':skill_name' => $skill_name)))
            {
                return $sth->fetch();
            }
            else
            {
                return 'Oops, there\'s no skill with that name';
            }
        }
        else
        {
            return 'There\'s an error with your code. We don\'t expect you to pass both $skill_category and $skill_name';
        }
    }
    /**
     * getLanguageCategories() gets all language categories from the database (coding languages)
     *
     * @return array of language categories
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function getLanguageCategories()
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        $query = 'SELECT id, category_name
                  FROM language_categories';
        $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute())
        {
            return $sth->fetchAll();
        }
        else
        {
            return 'Oops, no language categories found in the database.';
        }
    }
    /**
     * getLanguages() will get all languages from the database (coding languages)
     *
     * The method allows for pulling three different results:
     *
     *   + pull by the category of the language
     *   + pull by the language name (field_name in the table)
     *   + pull all languages
     *
     * @param string $category_id language category to pull (optional)
     * @param string $language_name language to pull from database (optional)
     * @access public
     * @return array with language information
     * @since Method available since Release 1.0.0
     */
    public function getLanguages($category_id = NULL, $language_name = NULL)
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        if (is_null($language_name) && is_null($category_id))
        {
            $query = 'SELECT field_name, experience, experience_level, icon, skills_categories.category_name
                      FROM languages
                      RIGHT JOIN language_categories
                      ON languages.category = language_categories.id';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute())
            {
                return $sth->fetchAll();
            }
            else
            {
                return 'Oops, no languages found.';
            }
        }
        else if (is_null($language_name) && !is_null($category_id))
        {
            $query = 'SELECT field_name, experience, experience_level, icon, skills_categories.category_name
                      FROM languages
                      RIGHT JOIN language_categories
                      ON languages.category = language_categories.id
                      WHERE languages.category = :language_category';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(':language_category' => $category_id)))
            {
                return $sth->fetchAll();
            }
            else
            {
                return 'Oops, no languages in this category.';
            }
        }
        else if (!is_null($language_name) && is_null($category_id))
        {
            $query = 'SELECT field_name, experience_level, icon, skills_categories.category_name
                      FROM languages
                      RIGHT JOIN skills_categories
                      ON languages.category = language_categories.id
                      WHERE languages.field_name = :language_name';
            $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if ($sth->execute(array(':language_name' => $language_name)))
            {
                return $sth->fetch();
            }
            else
            {
                return 'Oops, there\'s no language with that name';
            }
        }
        else
        {
            return 'There\'s an error with your code. We don\'t expect you to pass both $category_id and $language_name';
        }
    }
    /**
     * Get all work experience, and order them by year started, except where year ended is 0.
     *
     * In order to get the "Present" job on top, this method looks to ensure if the end_year
     * value is 0, it will be added to the top of the list.
     *
     * @return array of work experience results
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function getWorkExperience()
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        $query = 'SELECT year_start, year_end, company_name, company_description, official_title, daily_duties, extra_duties, featured_duties, awards, takeaways
                  FROM work_experience
                  ORDER BY year_start';
        $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute())
        {
            $new_array = array();
            $work_experience_array = $sth->fetchAll();
            foreach ($work_experience_array as $work_experience)
            {
                if ($work_experience['year_end'] == 0)
                {
                    array_unshift($new_array, $work_experience);
                }
                else
                {
                    $new_array[] = $work_experience;
                }
            }
            return $new_array;
        }
        else
        {
            return 'No work experience found.';
        }
    }
    /**
     * Get all volunteer experience, and order them by year started
     *
     * @return array of volunteer experience results
     * @access public
     * @since Method available since Release 1.0.0
     */
    public function getVolunteerExperience()
    {
        global $conn;
        if (!isset($conn))
        {
            $this->connect();
        }

        $query = 'SELECT year_start, year_end, organisation_name, organisation_description, daily_duties, extra_duties, featured_duties, awards, takeaways
                  FROM volunteer_experience
                  ORDER BY year_start';
        $sth = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if ($sth->execute())
        {
            return $sth->fetchAll();
        }
        else
        {
            return 'Oops, there\'s no volunteer data in the database.';
        }
    }
}
