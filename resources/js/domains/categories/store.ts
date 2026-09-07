import {storeModuleFactory} from '../../factories/storeFactory';
import {Http} from '../../facades/http';
import { computed } from 'vue';

export const categoryStore = storeModuleFactory('categories');