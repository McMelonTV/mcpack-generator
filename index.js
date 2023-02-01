const Fastify = require('fastify')
const fs = require('fs')
const zip = require('adm-zip')
const { v4: uuidv4 } = require('uuid')
const path = require('path')

const app = Fastify({
	logger: true
})

app.addContentTypeParser('application/x-www-form-urlencoded', { parseAs: 'buffer' }, function (request, body, done) {
	const parts = body.toString().split('&').map(part => part.split('='))
	const result = parts.reduce((acc, [key, value]) => {
		acc[key] = decodeURIComponent(value)
		return acc
	}, {})
	done(null, result)
})

app.post('/api', (request, reply) => {
	const height = request.body.height
	const theight = request.body.theight
	const heights = `${height} - ${theight}`

	if (height % 16 !== 0 || theight % 16 !== 0) {
		return reply.send({ message: 'Both heights must be a multiple of 16' })
	}

	if (!fs.existsSync('temp')) {
	fs.mkdirSync('temp')
	}
	if (!fs.existsSync('temp/dimensions')) {
	fs.mkdirSync('temp/dimensions')
	}	

	const manifestData = fs.readFileSync(path.join(__dirname, 'zip-stuff', 'manifest.json'))
	const overworldData = fs.readFileSync(path.join(__dirname, 'zip-stuff', 'dimensions', 'overworld.json'))

	const uuid1 = uuidv4()
	const uuid2 = uuidv4()

	const newManifestData = manifestData
		.toString()
		.replace(/{UUID1}/g, uuid1)
		.replace(/{UUID2}/g, uuid2)
		.replace(/{HEIGHTS}/g, heights)

	fs.writeFileSync(path.join(__dirname, 'temp', 'manifest.json'), newManifestData)

	const newOverworldData = overworldData
		.toString()
		.replace(/{MIN}/g, height)
		.replace(/{MAX}/g, theight)

	fs.writeFileSync(path.join(__dirname, 'temp', 'dimensions', 'overworld.json'), newOverworldData)

	const zipFile = new zip()
	zipFile.addLocalFolder('temp')
	zipFile.writeZip(`${heights}.mcpack`)

	const file = fs.createReadStream(`${heights}.mcpack`)
	reply.header('Content-Disposition', `attachment; filename=${heights}.mcpack`).send(file)

	setTimeout(() => {
	  fs.unlinkSync(`${heights}.mcpack`)
	}, 10000)
})

app.register(require('@fastify/static'), {
	root: path.join(__dirname, 'public'),
	prefix: '/',
})

app.get('/api', (request, reply) => {
		reply.send({ message: 'Usage: POST /api with a body of {"height": <INT -512 to 512>, "theight": <INT -512 to 512>}' })
})

app.listen({ port: 9090, host: '0.0.0.0' }, (err) => {
	if (err) {
		console.error(err)
		process.exit(1)
	}
	console.log('Server running on localhost:9090 with a /api endpoint')
})
