# bom
    Software BOM

# Login Credentials:
    Users:
    ics325@metrostate.edu
    ics499@metrostate.edu

## Botpress Setup:
    docs: https://botpress.com/docs/going-to-production/deploy
    tutorial: https://www.youtube.com/watch?v=6PZZIsRr2Ic

    ** REQUIREMENTS **
    - Git
    - nodejs 12.18.3 ([nvm-setup.exe](https://github.com/coreybutler/nvm-windows/releases/download/1.1.9/nvm-setup.exe) for windows is useful)
    - [yarn](https://github.com/yarnpkg/yarn/releases/download/v1.22.4/yarn-1.22.4.msi)

    - After you have all of the requirements, CD (change directory) ./src/api/
    - open a git terminal and download dependencies: ```yarn install```
    - build botpress: ```yarn build``` (this can take 10-15 min. to fully build)
    - start the botpress server ```yarn start``` (default: localhost:3000)
