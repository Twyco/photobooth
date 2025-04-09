import { AdminAlbumInterface } from '@/types/album-interface';

export interface Photobooth {
  id: number;
  name: string;
  active_album?: AdminAlbumInterface;
}
