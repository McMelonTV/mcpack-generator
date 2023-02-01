# Minecraft Addon Generator
Template NodeJS+Fastify site to generate Minecraft Bedrock Edition addons with content edited per user based on their input. There is currently no documentation but it should be pretty easy to understand with a basic knowledge of NodeJS and Fastify

There is also an older PHP version in the [php-version branch](https://github.com/McMelonTV/mcpack-generator/tree/php-version)

[DEMO Site](https://mcpack.alphafreak.pw/)

### How to use
0. Install [NodeJS](https://nodejs.org/)
1. Clone or download this repo
2. Run `npm install` to install the dependencies needed
3. Edit anything you want
4. Run `node .` or `node index.js` in the downloaded folder
5. Access the site and api on https://localhost:9090

### API Usage
POST: `http://<url>:<port>/api`

Body: (replace the values with your own)
```json
{"height": -512, "theight": 512}
```

> Made by [McMelon](https://github.com/McMelonTV) and [WolfDen133](https://github.com/WolfDen133) (Old PHP Version) | [NodiumHosting.com](https://nodiumhosting.com)
