# AutoRestart for PocketMine-MP

Simple plugin designed to make the server automatically restart after an user set interval.

## Installation
- Drop the plugin into the PocketMine's `plugins/` folder.
- Restart the server and a `config.yml` file will be generated in 'plugins/AutoRestart/'

## Configuration
| Name | Type | Description |
| :---: | :---: | :--- |
| __minutes__ | string | The set interval before the server restarts (in minutes). |

## Usage
Since the plugin is a bit like a timer and does the "stop" command after the interval, you must edit the `start.sh` or the `start.bat` file. Provided below is an example of a `start.sh` file with a while loop:

```bash
#!/bin/bash
DIR="$( cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$DIR"
if [ -f ./php5/bin/php ]; then
mkdir -m 0777 bin/
mv ./php5/bin/php ./bin/php
rm -r -f ./php5/
fi
while :
do
rm console.log
sleep 5
./bin/php -d enable_dl=On PocketMine-MP.php $@
done
read -p "Press [Enter] to continue..."
exit
```