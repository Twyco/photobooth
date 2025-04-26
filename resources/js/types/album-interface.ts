import { AlbumAccessCodeInterface } from '@/types/album-access-code-interface';
import { ImageSystemImage } from '@twyco/vue-image-system';

export interface UserAlbum {
  title: string;
  description: string;
  eventDate: string;
  uuid: string;
  cover: ImageSystemImage | null;
}
export interface UserAlbumWithImages extends UserAlbum {
  images: { original: string; compressed: string }[];
}

export interface AdminAlbumInterface extends UserAlbum {
  id: number;
  accessCodes: AlbumAccessCodeInterface[];
  qrCode: string;
}
