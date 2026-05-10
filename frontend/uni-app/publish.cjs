const fs = require('fs')
const { spawn } = require('child_process');
const path = require('path');

const main = () => {
    const params = process.argv.slice(2) || []
    const port = params[0] || ''
    const mode = params[1] || ''

    switch (port) {
        case 'h5':
            publish()
            break;
        case 'mp-weixin':
            if (mode == 'build') {
                handleWeappLanguage(mode)
            } else if (mode == 'dev') {
                listenWeappRunDev()
            }
            break;
    }
}

const publish = () => {
    const src = './dist/build/h5'
    const dest = '../../backend/public/wap'

    // 目标目录不存在停止复制
    try {
        const dir = fs.readdirSync(dest)
    } catch (e) {
        return
    }

    // 删除目标目录下文件
    fs.rm(dest, { recursive: true }, err => {
        if(err) {
            console.log(err)
            return
        }

        fs.cp(src, dest, { recursive: true }, (err) => {
            if (err) {
                console.error(err)
            }
        })
    })
}

const handleWeappLanguage = (mode) => {
    const src = `./dist/${mode}/mp-weixin/locale/language.js`

    try {
        let content = fs.readFileSync(src, 'utf8');
        content = content.replace(/Promise\.resolve\(require\(("[^"]+")\)\)/g, 'require.async($1)')
        fs.writeFileSync(src, content)
    } catch (err) {
        console.log(err)
    }
}

const listenWeappRunDev = () => {
    const devProcess = spawn('npm', ['run', 'dev:niu-mp-weixin'], {
        stdio: ['pipe', 'pipe', 'pipe'],
        shell: true
    });

    let serverReady = false;

    // 监听 stdout 输出
    devProcess.stdout.on('data', (data) => {
        const message = data.toString();
        console.log(message)
        if (!serverReady && message.includes('DONE  Build complete')) {
            serverReady = true;
            handleWeappLanguage('dev')
        }
    });

    // 监听 stderr 输出，用于捕获错误信息
    devProcess.stderr.on('data', (data) => {
        console.error(data.toString());
    });

    // 监听子进程退出事件
    devProcess.on('close', (code) => {
        if (code !== 0) { // 如果退出码不是0，则认为发生了错误
            console.error(`Child process exited with code ${code}`);
        } else {
            console.log('Child process exited successfully.');
        }
    });
}

main()
