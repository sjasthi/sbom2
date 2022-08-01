# bom
    Software BOM

# Login Credentials:
    Users:
    ics325@metrostate.edu
    ics499@metrostate.edu

# Botpress Setup:
* docs: https://botpress.com/docs/going-to-production/deploy
* tutorial: https://www.youtube.com/watch?v=6PZZIsRr2Ic

### REQUIREMENTS:
* Git [64-bit Git for Windows](https://github.com/git-for-windows/git/releases/download/v2.37.1.windows.1/Git-2.37.1-64-bit.exe)
* nodejs 12.18.3 ([nvm-setup.exe](https://github.com/coreybutler/nvm-windows/releases/download/1.1.9/nvm-setup.exe) for windows is useful)
* [yarn](https://github.com/yarnpkg/yarn/releases/download/v1.22.4/yarn-1.22.4.msi)

1. After you have all of the requirements, CD (change directory) ./src/api/
    1. open a git terminal and download dependencies: ```yarn install```
    2. build botpress: ```yarn build``` (this can take 10-15 min. to fully build)
    3. start the botpress server ```yarn start```

2. login to the botpress server by going to the server url location (default: localhost:3000).
3. import helper-bot under the create drop-down.
4. add the helper-bot avatar within `config > Avatar & Cover picture - Bot Avatar`
