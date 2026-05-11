<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            'html' => [
                ['q' => 'What does HTML stand for?',
                    'a' => ['HyperText Markup Language', 'HighText Machine Language', 'HyperText Machine Language', 'HyperTool Markup Language'], 'c' => 'HyperText Markup Language'],
                ['q' => 'Which tag is used to create a hyperlink in HTML?',
                    'a' => ['<a>', '<link>', '<href>', '<url>'], 'c' => '<a>'],
                ['q' => 'Which tag is used for the largest heading in HTML?',
                    'a' => ['<h1>', '<h6>', '<heading>', '<head>'], 'c' => '<h1>'],
                ['q' => 'What tag is used to insert an image?',
                    'a' => ['<img>', '<image>', '<pic>', '<src>'], 'c' => '<img>'],
                ['q' => 'Which HTML element defines the body of a document?',
                    'a' => ['<body>', '<main>', '<content>', '<div>'], 'c' => '<body>'],
                ['q' => 'What attribute specifies the URL of a link?',
                    'a' => ['href', 'src', 'url', 'link'], 'c' => 'href'],
                ['q' => 'Which tag creates an unordered list?',
                    'a' => ['<ul>', '<ol>', '<li>', '<list>'], 'c' => '<ul>'],
                ['q' => 'What does the <br> tag do?',
                    'a' => ['Inserts a line break', 'Bolds text', 'Creates a border', 'Breaks a table'], 'c' => 'Inserts a line break'],
                ['q' => 'Which tag is used to define a table row?',
                    'a' => ['<tr>', '<td>', '<th>', '<row>'], 'c' => '<tr>'],
                ['q' => 'What tag wraps the visible content of an HTML page?',
                    'a' => ['<body>', '<html>', '<main>', '<section>'], 'c' => '<body>'],
            ],

            'history' => [
                ['q' => 'Who was the first President of the United States?',
                    'a' => ['George Washington', 'Abraham Lincoln', 'Thomas Jefferson', 'John Adams'], 'c' => 'George Washington'],
                ['q' => 'In which year did World War II end?',
                    'a' => ['1945', '1943', '1947', '1939'], 'c' => '1945'],
                ['q' => 'Which ancient wonder was located in Alexandria?',
                    'a' => ['The Lighthouse', 'The Colossus', 'The Hanging Gardens', 'The Statue of Zeus'], 'c' => 'The Lighthouse'],
                ['q' => 'Who was the first man to walk on the Moon?',
                    'a' => ['Neil Armstrong', 'Buzz Aldrin', 'Yuri Gagarin', 'John Glenn'], 'c' => 'Neil Armstrong'],
                ['q' => 'The Berlin Wall fell in which year?',
                    'a' => ['1989', '1991', '1985', '1979'], 'c' => '1989'],
                ['q' => 'Which empire was ruled by Julius Caesar?',
                    'a' => ['Roman Empire', 'Greek Empire', 'Ottoman Empire', 'Byzantine Empire'], 'c' => 'Roman Empire'],
                ['q' => 'What year did Christopher Columbus reach the Americas?',
                    'a' => ['1492', '1486', '1501', '1510'], 'c' => '1492'],
                ['q' => 'The French Revolution began in which year?',
                    'a' => ['1789', '1776', '1804', '1799'], 'c' => '1789'],
                ['q' => 'Who was the first female Prime Minister of the United Kingdom?',
                    'a' => ['Margaret Thatcher', 'Theresa May', 'Queen Elizabeth II', 'Liz Truss'], 'c' => 'Margaret Thatcher'],
                ['q' => 'Which country was the first to grant women the right to vote?',
                    'a' => ['New Zealand', 'United States', 'United Kingdom', 'Australia'], 'c' => 'New Zealand'],
            ],

            'technology' => [
                ['q' => 'What does CPU stand for?',
                    'a' => ['Central Processing Unit', 'Core Processing Unit', 'Central Program Unit', 'Computer Processing Unit'], 'c' => 'Central Processing Unit'],
                ['q' => 'Which company created the iPhone?',
                    'a' => ['Apple', 'Samsung', 'Google', 'Microsoft'], 'c' => 'Apple'],
                ['q' => 'What is the most widely used programming language in 2024?',
                    'a' => ['JavaScript', 'Python', 'Java', 'C++'], 'c' => 'JavaScript'],
                ['q' => 'Who co-founded Microsoft?',
                    'a' => ['Bill Gates', 'Steve Jobs', 'Elon Musk', 'Mark Zuckerberg'], 'c' => 'Bill Gates'],
                ['q' => 'What does "HTTP" stand for?',
                    'a' => ['HyperText Transfer Protocol', 'HighText Transfer Protocol', 'HyperTool Transfer Protocol', 'HyperText Transit Protocol'], 'c' => 'HyperText Transfer Protocol'],
                ['q' => 'What year was the first iPhone released?',
                    'a' => ['2007', '2005', '2009', '2003'], 'c' => '2007'],
                ['q' => 'What does "GPU" stand for?',
                    'a' => ['Graphics Processing Unit', 'General Processing Unit', 'Graphics Program Unit', 'Global Processing Unit'], 'c' => 'Graphics Processing Unit'],
                ['q' => 'Which company developed the Android operating system?',
                    'a' => ['Google', 'Apple', 'Microsoft', 'Samsung'], 'c' => 'Google'],
                ['q' => 'What is the binary representation of the number 8?',
                    'a' => ['1000', '1010', '1100', '0111'], 'c' => '1000'],
                ['q' => 'What does "Wi-Fi" stand for?',
                    'a' => ['Wireless Fidelity', 'Wireless Frequency', 'Wide Fidelity', 'Wired Fidelity'], 'c' => 'Wireless Fidelity'],
            ],

            'pop-culture' => [
                ['q' => 'Who played Iron Man in the Marvel Cinematic Universe?',
                    'a' => ['Robert Downey Jr.', 'Chris Evans', 'Chris Hemsworth', 'Mark Ruffalo'], 'c' => 'Robert Downey Jr.'],
                ['q' => 'Which TV show features the fictional paper company Dunder Mifflin?',
                    'a' => ['The Office', 'Parks and Recreation', 'Brooklyn Nine-Nine', 'Arrested Development'], 'c' => 'The Office'],
                ['q' => 'What is the highest-grossing film of all time (not adjusted for inflation)?',
                    'a' => ['Avatar', 'Avengers: Endgame', 'Titanic', 'Star Wars: The Force Awakens'], 'c' => 'Avatar'],
                ['q' => 'Which singer is known as the "Queen of Pop"?',
                    'a' => ['Madonna', 'Beyoncé', 'Lady Gaga', 'Rihanna'], 'c' => 'Madonna'],
                ['q' => 'In which year did the first Harry Potter book publish?',
                    'a' => ['1997', '1995', '1999', '2001'], 'c' => '1997'],
                ['q' => 'Who directed the movie "Inception"?',
                    'a' => ['Christopher Nolan', 'James Cameron', 'Steven Spielberg', 'Ridley Scott'], 'c' => 'Christopher Nolan'],
                ['q' => 'What color is the dress in the famous 2015 viral internet debate?',
                    'a' => ['Blue and black / White and gold', 'Red and green', 'Yellow and purple', 'Pink and grey'], 'c' => 'Blue and black / White and gold'],
                ['q' => 'What streaming service produced "Stranger Things"?',
                    'a' => ['Netflix', 'HBO', 'Amazon Prime', 'Disney+'], 'c' => 'Netflix'],
                ['q' => 'Which movie features the quote "I\'ll be back"?',
                    'a' => ['The Terminator', 'RoboCop', 'Predator', 'Die Hard'], 'c' => 'The Terminator'],
                ['q' => 'What is the name of the lion in "The Lion King"?',
                    'a' => ['Simba', 'Mufasa', 'Nala', 'Scar'], 'c' => 'Simba'],
            ],

            'music' => [
                ['q' => 'Who is known as the "King of Rock and Roll"?',
                    'a' => ['Elvis Presley', 'Chuck Berry', 'Little Richard', 'Jerry Lee Lewis'], 'c' => 'Elvis Presley'],
                ['q' => 'How many strings does a standard guitar have?',
                    'a' => ['6', '4', '8', '12'], 'c' => '6'],
                ['q' => 'Which band released the album "Dark Side of the Moon"?',
                    'a' => ['Pink Floyd', 'Led Zeppelin', 'The Beatles', 'The Rolling Stones'], 'c' => 'Pink Floyd'],
                ['q' => 'What does BPM stand for in music?',
                    'a' => ['Beats Per Minute', 'Bass Per Measure', 'Beats Per Measure', 'Bass Per Minute'], 'c' => 'Beats Per Minute'],
                ['q' => 'Which country does the musical genre "Reggae" originate from?',
                    'a' => ['Jamaica', 'Brazil', 'Cuba', 'Trinidad'], 'c' => 'Jamaica'],
                ['q' => 'Who wrote the opera "The Magic Flute"?',
                    'a' => ['Mozart', 'Beethoven', 'Bach', 'Handel'], 'c' => 'Mozart'],
                ['q' => 'What is the highest female singing voice called?',
                    'a' => ['Soprano', 'Alto', 'Mezzo-soprano', 'Contralto'], 'c' => 'Soprano'],
                ['q' => 'Which artist has the most Grammy wins of all time?',
                    'a' => ['Beyoncé', 'Georg Solti', 'Quincy Jones', 'Taylor Swift'], 'c' => 'Beyoncé'],
                ['q' => 'What does the musical term "forte" mean?',
                    'a' => ['Loud', 'Soft', 'Fast', 'Slow'], 'c' => 'Loud'],
                ['q' => 'Which band is "Bohemian Rhapsody" by?',
                    'a' => ['Queen', 'The Beatles', 'Led Zeppelin', 'David Bowie'], 'c' => 'Queen'],
            ],

            'laravel' => [
                ['q' => 'What command creates a new Laravel project?',
                    'a' => ['composer create-project laravel/laravel', 'laravel new project', 'php artisan new', 'npm create laravel'], 'c' => 'composer create-project laravel/laravel'],
                ['q' => 'What is the default ORM used in Laravel?',
                    'a' => ['Eloquent', 'Doctrine', 'Propel', 'RedBean'], 'c' => 'Eloquent'],
                ['q' => 'Which command runs database migrations?',
                    'a' => ['php artisan migrate', 'php artisan db:migrate', 'php artisan run:migration', 'php artisan migration:run'], 'c' => 'php artisan migrate'],
                ['q' => 'What file defines Laravel application routes?',
                    'a' => ['routes/web.php', 'app/routes.php', 'config/routes.php', 'http/routes.php'], 'c' => 'routes/web.php'],
                ['q' => 'What does the "php artisan tinker" command do?',
                    'a' => ['Opens an interactive REPL', 'Runs tests', 'Clears the cache', 'Starts the server'], 'c' => 'Opens an interactive REPL'],
                ['q' => 'Which templating engine does Laravel use by default?',
                    'a' => ['Blade', 'Twig', 'Smarty', 'Mustache'], 'c' => 'Blade'],
                ['q' => 'What is Laravel Horizon used for?',
                    'a' => ['Monitoring Redis queues', 'Database backups', 'Email sending', 'File storage'], 'c' => 'Monitoring Redis queues'],
                ['q' => 'What method is used to define a one-to-many relationship in Eloquent?',
                    'a' => ['hasMany()', 'belongsTo()', 'hasOne()', 'belongsToMany()'], 'c' => 'hasMany()'],
                ['q' => 'Which command generates a new controller?',
                    'a' => ['php artisan make:controller', 'php artisan create:controller', 'php artisan new:controller', 'php artisan controller:make'], 'c' => 'php artisan make:controller'],
                ['q' => 'What is the purpose of Laravel middleware?',
                    'a' => ['Filter HTTP requests', 'Define database schema', 'Send emails', 'Compile assets'], 'c' => 'Filter HTTP requests'],
            ],

            'php' => [
                ['q' => 'What does PHP stand for?',
                    'a' => ['PHP: Hypertext Preprocessor', 'Personal Home Page', 'Preprocessed Hypertext Pages', 'Private Hypertext Protocol'], 'c' => 'PHP: Hypertext Preprocessor'],
                ['q' => 'Which symbol is used to declare a variable in PHP?',
                    'a' => ['$', '@', '#', '&'], 'c' => '$'],
                ['q' => 'What function is used to output text in PHP?',
                    'a' => ['echo', 'print_text', 'output', 'display'], 'c' => 'echo'],
                ['q' => 'Which of these is the correct way to start a PHP block?',
                    'a' => ['<?php', '<php>', '<?', '<script php>'], 'c' => '<?php'],
                ['q' => 'What does the "===" operator check in PHP?',
                    'a' => ['Value and type equality', 'Value equality only', 'Type equality only', 'Reference equality'], 'c' => 'Value and type equality'],
                ['q' => 'Which function returns the length of a string in PHP?',
                    'a' => ['strlen()', 'length()', 'strcount()', 'count()'], 'c' => 'strlen()'],
                ['q' => 'What is a PHP trait used for?',
                    'a' => ['Code reuse across classes', 'Database connections', 'Error handling', 'Session management'], 'c' => 'Code reuse across classes'],
                ['q' => 'Which superglobal holds form POST data?',
                    'a' => ['$_POST', '$_FORM', '$_INPUT', '$_REQUEST_POST'], 'c' => '$_POST'],
                ['q' => 'What does the "null coalescing operator" (??) do?',
                    'a' => ['Returns right side if left is null', 'Checks for empty strings', 'Converts null to false', 'Merges two arrays'], 'c' => 'Returns right side if left is null'],
                ['q' => 'Which function merges two arrays in PHP?',
                    'a' => ['array_merge()', 'merge_array()', 'array_combine()', 'array_push()'], 'c' => 'array_merge()'],
            ],

        ];

        foreach ($data as $slug => $questions) {
            $topic = Topic::where('slug', $slug)->first();
            if (!$topic) continue;

            // Clear existing
            Answer::whereHas('question', function($query) use ($topic) {
                $query->where('topic_id', $topic->id);
            })->delete();
            $topic->questions()->delete();

            foreach ($questions as $item) {
                $question = Question::create([
                    'topic_id'      => $topic->id,
                    'question_text' => $item['q'],
                ]);

                foreach ($item['a'] as $answerText) {
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => $answerText,
                        'is_correct'  => $answerText === $item['c'],
                    ]);
                }
            }
        }
    }
}