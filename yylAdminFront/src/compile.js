import fs from 'fs';
import { parse, compileTemplate } from '@vue/compiler-sfc';
import babel from '@babel/core';

// 读取 Vue 文件
const vueFile = fs.readFileSync('./src/App.vue', 'utf-8');

// 提取模板、脚本和样式
const descriptor = parse(vueFile).descriptor;

// 编译模板
const compiledTemplate = compileTemplate({
  source: descriptor.template.content,
  filename: 'App.vue',
  id: 'App.vue'
});

// 编译脚本
const { code: compiledScript } = babel.transformSync(descriptor.script.content, {
  presets: ['@babel/preset-env']
});

// 输出编译后的代码到文件
fs.writeFileSync('./dist/compiledTemplate.js', compiledTemplate.code);
fs.writeFileSync('./dist/compiledScript.js', compiledScript);

console.log('Compiled Template and Script have been saved to the dist directory.');