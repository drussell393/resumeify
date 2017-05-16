<!DOCTYPE html>
<html>
    <head>
        <title>Shpock CV - Dave Russell Jr</title>
        <link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URI; ?>shpock/assets/css/main.css?v=<?php echo time(); ?>">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="topbar">
            <img src="https://webstatic.secondhandapp.com/style/r1493970017/images/logo.png" />
            <i id="favourite" class="fa fa-star-o fa-2x"></i>
            <script type="text/javascript">
                document.getElementById('favourite').onclick = function() {
                    if (document.getElementById('favourite').classList.contains('fa-star-o')) {
                        document.getElementById('favourite').classList = 'fa fa-star fa-2x';
                    }
                    else
                    {
                        document.getElementById('favourite').classList = 'fa fa-star-o fa-2x';
                    }
                };
            </script>
        </div>
        <div class="hero">
            <div class="image">
                <img src="/templates/shpock/assets/images/headshot.jpg?v=0.01" class="headshot" />
                <a href="https://github.com/drussell393/resumeify">PHP Source on GitHub</a>
            </div>
            <div class="personal">
                <?php
                foreach ($database->getPersonalDetails() as $personal_detail)
                {
                    echo '<p class="title">' . $personal_detail['field_name'] . '</p>';
                    echo '<p class="value">' . $personal_detail['value'] . '</p>';
                }
                ?>
            </div>
        </div>
        <div class="resume-skills">
            <h1>Related Skills</h1>
            <?php
            foreach ($database->getSkillCategories() as $skill_category)
            {
                echo '<div class="skill-category">';
                echo '<h3>' . $skill_category['category_name'] . '</h4>';
                foreach ($database->getSkills($skill_name = NULL, $skill_category = $skill_category['id']) as $skill)
                {
                    echo '<h4><i class="fa fa-' . $skill['icon'] . ' fa-2x" data-percentage="' . $skill['experience_level'] . '"></i> ' . $skill['field_name'] . '</h4>';
                    if (!empty($skill['experience']))
                    {
                        echo $skill['experience'];
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="languages">
            <h1>Coding Languages I know...</h2>
            <?php
            foreach ($database->getLanguageCategories() as $language_category)
            {
                echo '<div class="language-category">';
                echo '<h3>' . $language_category['category_name'] . '</h3>';
                foreach ($database->getLanguages($category_id = $language_category['id'], $language_name = NULL) as $language)
                {
                    echo '<h4><i class="fa fa-' . $language['icon'] . ' fa-2x" data-percentage="' . $language['experience_level'] . '"></i> ' . $language['field_name'] . '</h4>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div class="work-experience">
            <h1>Work Experience</h1>
            <?php
            foreach ($database->getWorkExperience() as $work_experience)
            {
                echo '<div class="job">';
                echo '<h2>' . $work_experience['company_name'] . '</h2>';
                echo '<h4>' . $work_experience['company_description'] . '</h4>';
                echo '<p class="official-title">' . $work_experience['official_title'] . '</p>';
                echo '<span class="year_start">' . $work_experience['year_start'] . '</span>';
                echo '<span class="year_end">' . ($work_experience['year_end'] == 0 ? 'Present' : $work_experience['year_end']) . '</span>';
                echo '<h5>Day to Day Duties</h5>';
                echo $work_experience['daily_duties'];
                if (!empty($work_experience['extra_duties']))
                {
                    echo '<h5>Extra Duties</h5>';
                    echo $work_experience['extra_duties'];
                }
                if (!empty($work_experience['featured_duties']))
                {
                    echo '<h5>Featured Accomplishments</h5>';
                    echo $work_experience['featured_duties'];
                }
                if (!empty($work_experience['awards']))
                {
                    echo '<h5>Awards</h5>';
                    echo $work_experience['awards'];
                }
                echo '<h5>Takeaways</h5>';
                echo '<p class="takeaway">' . $work_experience['takeaways'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="volunteer-experience">
            <h1>Volunteer Experience</h1>
            <?php
            foreach ($database->getVolunteerExperience() as $volunteer_experience)
            {
                echo '<div class="volunteer">';
                echo '<h2>' . $volunteer_experience['organisation_name'] . '</h2>';
                echo '<h4>' . $volunteer_experience['organisation_description'] . '</h4>';
                echo '<span class="year_start">' . $volunteer_experience['year_start'] . '</span>';
                echo '<span class="year_end">' . $volunteer_experience['year_end'] . '</span>';
                echo '<h5>Day to Day Duties</h5>';
                echo $volunteer_experience['daily_duties'];
                if (!empty($volunteer_experience['extra_duties']))
                {
                    echo $volunteer_experience['extra_duties'];
                }
                echo '<h5>Takeaways</h5>';
                echo '<p class="takeaways">' . $volunteer_experience['takeaways'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="social">
            <h1>Stalk me on Social Media</h1>
            <ul class="social">
                <li><a href="https://twitter.com/daverusselljr"><i class="fa fa-twitter fa-2x"></i></a></li>
                <li><a href="https://instagram.com/drussell393"><i class="fa fa-instagram fa-2x"></i></a></li>
                <li><a href="https://github.com/drussell393"><i class="fa fa-github fa-2x"></i></a></li>
            </ul>
        </div>
    </body>
</html>
