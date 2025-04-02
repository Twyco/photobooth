import { AlbumAccessCodeInterface } from '@/types/album-access-code-interface';

export interface UserAlbum {
  title: string;
  description: string;
  eventDate: string;
  uuid: string;
  cover: string | null;
}
export interface UserAlbumWithImages extends UserAlbum {
  images: { original: string; compressed: string }[];
}

export interface AdminAlbumInterface extends UserAlbumWithImages {
  id: number;
  accessCodes: AlbumAccessCodeInterface[];
  qrCode: string;
}
