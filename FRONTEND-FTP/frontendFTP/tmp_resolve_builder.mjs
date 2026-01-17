import { createRequire } from 'module';
import fs from 'fs';
const req = createRequire(import.meta.url);
try {
  const resolved = req.resolve('@nuxt/vite-builder');
  console.log('resolved ->', resolved);
  const content = fs.readFileSync(resolved,'utf8');
  console.log('first 200 chars:\n', content.slice(0,200));
} catch(e) {
  console.error('ERR', e);
  process.exit(1);
}
