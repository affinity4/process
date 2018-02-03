# Process

Promise/A+ wrapper around a proc_open function

## Usage

```

require __DIR__ . './vendor/autoload.php';

Affinity4\Process\Process::execute('dir .')->then(
    // On success
    function ($output) {
        echo $output; // Show output from "dir ." command (Windows)
    },

    // On Fail
    function ($output) {
        // Log error or do something else...
    }
);

```

## Licence

MIT

&copy; 2018
