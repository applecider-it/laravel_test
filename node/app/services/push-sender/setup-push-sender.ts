
import { loadEnv } from '@/services/system/env.ts';

import { senderMain} from './sender';

loadEnv();

senderMain().then(() => process.exit());
