PGDMP      -                }            dbGestionJL    17.4    17.4 Y    .           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            /           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            0           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            1           1262    16388    dbGestionJL    DATABASE     s   CREATE DATABASE "dbGestionJL" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'es-PE';
    DROP DATABASE "dbGestionJL";
                     postgres    false            �            1259    16656    administrador    TABLE     �   CREATE TABLE public.administrador (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL
);
 !   DROP TABLE public.administrador;
       public         heap r       postgres    false            �            1259    16655    administrador_id_seq    SEQUENCE     �   CREATE SEQUENCE public.administrador_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 +   DROP SEQUENCE public.administrador_id_seq;
       public               postgres    false    222            2           0    0    administrador_id_seq    SEQUENCE OWNED BY     M   ALTER SEQUENCE public.administrador_id_seq OWNED BY public.administrador.id;
          public               postgres    false    221            �            1259    16735    calendario_incidencia    TABLE     �   CREATE TABLE public.calendario_incidencia (
    id integer NOT NULL,
    incidencia_id integer,
    fecha_programada date NOT NULL,
    observaciones text
);
 )   DROP TABLE public.calendario_incidencia;
       public         heap r       postgres    false            �            1259    16734    calendario_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.calendario_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.calendario_incidencia_id_seq;
       public               postgres    false    230            3           0    0    calendario_incidencia_id_seq    SEQUENCE OWNED BY     ]   ALTER SEQUENCE public.calendario_incidencia_id_seq OWNED BY public.calendario_incidencia.id;
          public               postgres    false    229            �            1259    16667    empleado    TABLE       CREATE TABLE public.empleado (
    id integer NOT NULL,
    dni character(8) NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password text NOT NULL,
    creado_por integer
);
    DROP TABLE public.empleado;
       public         heap r       postgres    false            �            1259    16666    empleado_id_seq    SEQUENCE     �   CREATE SEQUENCE public.empleado_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.empleado_id_seq;
       public               postgres    false    224            4           0    0    empleado_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.empleado_id_seq OWNED BY public.empleado.id;
          public               postgres    false    223            �            1259    16784    empleado_token    TABLE     �   CREATE TABLE public.empleado_token (
    id integer NOT NULL,
    empleado_id integer,
    token text NOT NULL,
    creado timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
 "   DROP TABLE public.empleado_token;
       public         heap r       postgres    false            �            1259    16783    empleado_token_id_seq    SEQUENCE     �   CREATE SEQUENCE public.empleado_token_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.empleado_token_id_seq;
       public               postgres    false    236            5           0    0    empleado_token_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.empleado_token_id_seq OWNED BY public.empleado_token.id;
          public               postgres    false    235            �            1259    16648    estado_incidencia    TABLE     2  CREATE TABLE public.estado_incidencia (
    id integer NOT NULL,
    nombre character varying(50) NOT NULL,
    CONSTRAINT estado_incidencia_nombre_check CHECK (((nombre)::text = ANY ((ARRAY['Pendiente'::character varying, 'En Desarrollo'::character varying, 'Terminado'::character varying])::text[])))
);
 %   DROP TABLE public.estado_incidencia;
       public         heap r       postgres    false            �            1259    16647    estado_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.estado_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.estado_incidencia_id_seq;
       public               postgres    false    220            6           0    0    estado_incidencia_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.estado_incidencia_id_seq OWNED BY public.estado_incidencia.id;
          public               postgres    false    219            �            1259    16712    historial_estado    TABLE     �   CREATE TABLE public.historial_estado (
    id integer NOT NULL,
    incidencia_id integer,
    estado_id integer,
    fecha_cambio timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    empleado_id integer
);
 $   DROP TABLE public.historial_estado;
       public         heap r       postgres    false            �            1259    16711    historial_estado_id_seq    SEQUENCE     �   CREATE SEQUENCE public.historial_estado_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.historial_estado_id_seq;
       public               postgres    false    228            7           0    0    historial_estado_id_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.historial_estado_id_seq OWNED BY public.historial_estado.id;
          public               postgres    false    227            �            1259    16685 
   incidencia    TABLE     G  CREATE TABLE public.incidencia (
    id integer NOT NULL,
    tipo_id integer,
    descripcion text NOT NULL,
    foto bytea,
    latitud numeric(9,6) NOT NULL,
    longitud numeric(9,6) NOT NULL,
    direccion character varying(255),
    fecha_reporte timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    estado_id integer DEFAULT 1,
    asignado_a integer,
    atendido boolean DEFAULT false,
    prioridad_id integer,
    zona character varying(100),
    clasificada boolean DEFAULT false,
    clasificada_por integer,
    fecha_clasificacion timestamp without time zone
);
    DROP TABLE public.incidencia;
       public         heap r       postgres    false            �            1259    16684    incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.incidencia_id_seq;
       public               postgres    false    226            8           0    0    incidencia_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.incidencia_id_seq OWNED BY public.incidencia.id;
          public               postgres    false    225            �            1259    16749 	   log_admin    TABLE     �   CREATE TABLE public.log_admin (
    id integer NOT NULL,
    admin_id integer,
    accion text NOT NULL,
    fecha timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.log_admin;
       public         heap r       postgres    false            �            1259    16748    log_admin_id_seq    SEQUENCE     �   CREATE SEQUENCE public.log_admin_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.log_admin_id_seq;
       public               postgres    false    232            9           0    0    log_admin_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.log_admin_id_seq OWNED BY public.log_admin.id;
          public               postgres    false    231            �            1259    16765 	   prioridad    TABLE       CREATE TABLE public.prioridad (
    id integer NOT NULL,
    nivel character varying(50) NOT NULL,
    CONSTRAINT prioridad_nivel_check CHECK (((nivel)::text = ANY ((ARRAY['Alta'::character varying, 'Media'::character varying, 'Baja'::character varying])::text[])))
);
    DROP TABLE public.prioridad;
       public         heap r       postgres    false            �            1259    16764    prioridad_id_seq    SEQUENCE     �   CREATE SEQUENCE public.prioridad_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.prioridad_id_seq;
       public               postgres    false    234            :           0    0    prioridad_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.prioridad_id_seq OWNED BY public.prioridad.id;
          public               postgres    false    233            �            1259    16639    tipo_incidencia    TABLE     �   CREATE TABLE public.tipo_incidencia (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    descripcion text
);
 #   DROP TABLE public.tipo_incidencia;
       public         heap r       postgres    false            �            1259    16638    tipo_incidencia_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tipo_incidencia_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.tipo_incidencia_id_seq;
       public               postgres    false    218            ;           0    0    tipo_incidencia_id_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.tipo_incidencia_id_seq OWNED BY public.tipo_incidencia.id;
          public               postgres    false    217            P           2604    16659    administrador id    DEFAULT     t   ALTER TABLE ONLY public.administrador ALTER COLUMN id SET DEFAULT nextval('public.administrador_id_seq'::regclass);
 ?   ALTER TABLE public.administrador ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    221    222            Y           2604    16738    calendario_incidencia id    DEFAULT     �   ALTER TABLE ONLY public.calendario_incidencia ALTER COLUMN id SET DEFAULT nextval('public.calendario_incidencia_id_seq'::regclass);
 G   ALTER TABLE public.calendario_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    229    230    230            Q           2604    16670    empleado id    DEFAULT     j   ALTER TABLE ONLY public.empleado ALTER COLUMN id SET DEFAULT nextval('public.empleado_id_seq'::regclass);
 :   ALTER TABLE public.empleado ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    223    224            ]           2604    16787    empleado_token id    DEFAULT     v   ALTER TABLE ONLY public.empleado_token ALTER COLUMN id SET DEFAULT nextval('public.empleado_token_id_seq'::regclass);
 @   ALTER TABLE public.empleado_token ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    235    236    236            O           2604    16651    estado_incidencia id    DEFAULT     |   ALTER TABLE ONLY public.estado_incidencia ALTER COLUMN id SET DEFAULT nextval('public.estado_incidencia_id_seq'::regclass);
 C   ALTER TABLE public.estado_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    219    220    220            W           2604    16715    historial_estado id    DEFAULT     z   ALTER TABLE ONLY public.historial_estado ALTER COLUMN id SET DEFAULT nextval('public.historial_estado_id_seq'::regclass);
 B   ALTER TABLE public.historial_estado ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    227    228            R           2604    16688    incidencia id    DEFAULT     n   ALTER TABLE ONLY public.incidencia ALTER COLUMN id SET DEFAULT nextval('public.incidencia_id_seq'::regclass);
 <   ALTER TABLE public.incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    225    226    226            Z           2604    16752    log_admin id    DEFAULT     l   ALTER TABLE ONLY public.log_admin ALTER COLUMN id SET DEFAULT nextval('public.log_admin_id_seq'::regclass);
 ;   ALTER TABLE public.log_admin ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    232    231    232            \           2604    16768    prioridad id    DEFAULT     l   ALTER TABLE ONLY public.prioridad ALTER COLUMN id SET DEFAULT nextval('public.prioridad_id_seq'::regclass);
 ;   ALTER TABLE public.prioridad ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    234    233    234            N           2604    16642    tipo_incidencia id    DEFAULT     x   ALTER TABLE ONLY public.tipo_incidencia ALTER COLUMN id SET DEFAULT nextval('public.tipo_incidencia_id_seq'::regclass);
 A   ALTER TABLE public.tipo_incidencia ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    218    217    218                      0    16656    administrador 
   TABLE DATA           N   COPY public.administrador (id, nombre, apellido, email, password) FROM stdin;
    public               postgres    false    222   �o       %          0    16735    calendario_incidencia 
   TABLE DATA           c   COPY public.calendario_incidencia (id, incidencia_id, fecha_programada, observaciones) FROM stdin;
    public               postgres    false    230   fp                 0    16667    empleado 
   TABLE DATA           Z   COPY public.empleado (id, dni, nombre, apellido, email, password, creado_por) FROM stdin;
    public               postgres    false    224   �p       +          0    16784    empleado_token 
   TABLE DATA           H   COPY public.empleado_token (id, empleado_id, token, creado) FROM stdin;
    public               postgres    false    236   
q                 0    16648    estado_incidencia 
   TABLE DATA           7   COPY public.estado_incidencia (id, nombre) FROM stdin;
    public               postgres    false    220   'q       #          0    16712    historial_estado 
   TABLE DATA           c   COPY public.historial_estado (id, incidencia_id, estado_id, fecha_cambio, empleado_id) FROM stdin;
    public               postgres    false    228   Dq       !          0    16685 
   incidencia 
   TABLE DATA           �   COPY public.incidencia (id, tipo_id, descripcion, foto, latitud, longitud, direccion, fecha_reporte, estado_id, asignado_a, atendido, prioridad_id, zona, clasificada, clasificada_por, fecha_clasificacion) FROM stdin;
    public               postgres    false    226   aq       '          0    16749 	   log_admin 
   TABLE DATA           @   COPY public.log_admin (id, admin_id, accion, fecha) FROM stdin;
    public               postgres    false    232   ~q       )          0    16765 	   prioridad 
   TABLE DATA           .   COPY public.prioridad (id, nivel) FROM stdin;
    public               postgres    false    234   �q                 0    16639    tipo_incidencia 
   TABLE DATA           B   COPY public.tipo_incidencia (id, nombre, descripcion) FROM stdin;
    public               postgres    false    218   �q       <           0    0    administrador_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.administrador_id_seq', 1, true);
          public               postgres    false    221            =           0    0    calendario_incidencia_id_seq    SEQUENCE SET     K   SELECT pg_catalog.setval('public.calendario_incidencia_id_seq', 1, false);
          public               postgres    false    229            >           0    0    empleado_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.empleado_id_seq', 1, true);
          public               postgres    false    223            ?           0    0    empleado_token_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.empleado_token_id_seq', 1, false);
          public               postgres    false    235            @           0    0    estado_incidencia_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.estado_incidencia_id_seq', 1, false);
          public               postgres    false    219            A           0    0    historial_estado_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.historial_estado_id_seq', 1, false);
          public               postgres    false    227            B           0    0    incidencia_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.incidencia_id_seq', 1, false);
          public               postgres    false    225            C           0    0    log_admin_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.log_admin_id_seq', 1, false);
          public               postgres    false    231            D           0    0    prioridad_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.prioridad_id_seq', 1, false);
          public               postgres    false    233            E           0    0    tipo_incidencia_id_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.tipo_incidencia_id_seq', 1, false);
          public               postgres    false    217            f           2606    16665 %   administrador administrador_email_key 
   CONSTRAINT     a   ALTER TABLE ONLY public.administrador
    ADD CONSTRAINT administrador_email_key UNIQUE (email);
 O   ALTER TABLE ONLY public.administrador DROP CONSTRAINT administrador_email_key;
       public                 postgres    false    222            h           2606    16663     administrador administrador_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.administrador
    ADD CONSTRAINT administrador_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.administrador DROP CONSTRAINT administrador_pkey;
       public                 postgres    false    222            t           2606    16742 0   calendario_incidencia calendario_incidencia_pkey 
   CONSTRAINT     n   ALTER TABLE ONLY public.calendario_incidencia
    ADD CONSTRAINT calendario_incidencia_pkey PRIMARY KEY (id);
 Z   ALTER TABLE ONLY public.calendario_incidencia DROP CONSTRAINT calendario_incidencia_pkey;
       public                 postgres    false    230            j           2606    16676    empleado empleado_dni_key 
   CONSTRAINT     S   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_dni_key UNIQUE (dni);
 C   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_dni_key;
       public                 postgres    false    224            l           2606    16678    empleado empleado_email_key 
   CONSTRAINT     W   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_email_key UNIQUE (email);
 E   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_email_key;
       public                 postgres    false    224            n           2606    16674    empleado empleado_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_pkey;
       public                 postgres    false    224            z           2606    16792 "   empleado_token empleado_token_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.empleado_token
    ADD CONSTRAINT empleado_token_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.empleado_token DROP CONSTRAINT empleado_token_pkey;
       public                 postgres    false    236            d           2606    16654 (   estado_incidencia estado_incidencia_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.estado_incidencia
    ADD CONSTRAINT estado_incidencia_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.estado_incidencia DROP CONSTRAINT estado_incidencia_pkey;
       public                 postgres    false    220            r           2606    16718 &   historial_estado historial_estado_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_pkey;
       public                 postgres    false    228            p           2606    16695    incidencia incidencia_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_pkey;
       public                 postgres    false    226            v           2606    16757    log_admin log_admin_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.log_admin
    ADD CONSTRAINT log_admin_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.log_admin DROP CONSTRAINT log_admin_pkey;
       public                 postgres    false    232            x           2606    16771    prioridad prioridad_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.prioridad
    ADD CONSTRAINT prioridad_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.prioridad DROP CONSTRAINT prioridad_pkey;
       public                 postgres    false    234            b           2606    16646 $   tipo_incidencia tipo_incidencia_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.tipo_incidencia
    ADD CONSTRAINT tipo_incidencia_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.tipo_incidencia DROP CONSTRAINT tipo_incidencia_pkey;
       public                 postgres    false    218            �           2606    16743 >   calendario_incidencia calendario_incidencia_incidencia_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.calendario_incidencia
    ADD CONSTRAINT calendario_incidencia_incidencia_id_fkey FOREIGN KEY (incidencia_id) REFERENCES public.incidencia(id);
 h   ALTER TABLE ONLY public.calendario_incidencia DROP CONSTRAINT calendario_incidencia_incidencia_id_fkey;
       public               postgres    false    230    4720    226            {           2606    16679 !   empleado empleado_creado_por_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.empleado
    ADD CONSTRAINT empleado_creado_por_fkey FOREIGN KEY (creado_por) REFERENCES public.administrador(id);
 K   ALTER TABLE ONLY public.empleado DROP CONSTRAINT empleado_creado_por_fkey;
       public               postgres    false    224    4712    222            �           2606    16793 .   empleado_token empleado_token_empleado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.empleado_token
    ADD CONSTRAINT empleado_token_empleado_id_fkey FOREIGN KEY (empleado_id) REFERENCES public.empleado(id);
 X   ALTER TABLE ONLY public.empleado_token DROP CONSTRAINT empleado_token_empleado_id_fkey;
       public               postgres    false    4718    236    224            �           2606    16729 2   historial_estado historial_estado_empleado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_empleado_id_fkey FOREIGN KEY (empleado_id) REFERENCES public.empleado(id);
 \   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_empleado_id_fkey;
       public               postgres    false    4718    224    228            �           2606    16724 0   historial_estado historial_estado_estado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_estado_id_fkey FOREIGN KEY (estado_id) REFERENCES public.estado_incidencia(id);
 Z   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_estado_id_fkey;
       public               postgres    false    220    228    4708            �           2606    16719 4   historial_estado historial_estado_incidencia_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.historial_estado
    ADD CONSTRAINT historial_estado_incidencia_id_fkey FOREIGN KEY (incidencia_id) REFERENCES public.incidencia(id);
 ^   ALTER TABLE ONLY public.historial_estado DROP CONSTRAINT historial_estado_incidencia_id_fkey;
       public               postgres    false    4720    226    228            |           2606    16706 %   incidencia incidencia_asignado_a_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_asignado_a_fkey FOREIGN KEY (asignado_a) REFERENCES public.empleado(id);
 O   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_asignado_a_fkey;
       public               postgres    false    224    4718    226            }           2606    16778 *   incidencia incidencia_clasificada_por_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_clasificada_por_fkey FOREIGN KEY (clasificada_por) REFERENCES public.administrador(id);
 T   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_clasificada_por_fkey;
       public               postgres    false    4712    222    226            ~           2606    16701 $   incidencia incidencia_estado_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_estado_id_fkey FOREIGN KEY (estado_id) REFERENCES public.estado_incidencia(id);
 N   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_estado_id_fkey;
       public               postgres    false    4708    220    226                       2606    16772 '   incidencia incidencia_prioridad_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_prioridad_id_fkey FOREIGN KEY (prioridad_id) REFERENCES public.prioridad(id);
 Q   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_prioridad_id_fkey;
       public               postgres    false    226    234    4728            �           2606    16696 "   incidencia incidencia_tipo_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.incidencia
    ADD CONSTRAINT incidencia_tipo_id_fkey FOREIGN KEY (tipo_id) REFERENCES public.tipo_incidencia(id);
 L   ALTER TABLE ONLY public.incidencia DROP CONSTRAINT incidencia_tipo_id_fkey;
       public               postgres    false    218    226    4706            �           2606    16758 !   log_admin log_admin_admin_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.log_admin
    ADD CONSTRAINT log_admin_admin_id_fkey FOREIGN KEY (admin_id) REFERENCES public.administrador(id);
 K   ALTER TABLE ONLY public.log_admin DROP CONSTRAINT log_admin_admin_id_fkey;
       public               postgres    false    232    222    4712               j   x�3���/JO�tN,.I<�15%�3+�!=713G/9?�SŨR��@�88�2�/é��\��2ԭ$-@ߢ4�0�0,��;��<�����'52������9�"�(�+F��� J��      %      x������ � �         w   x�3�0�4��06���/JO�tN,.I<�15%�3+�!9�H/5�T� �SŨR��@%��"�"�����D/1'�4Ȱ<9�����'*#J/�G/)"ձ� $%,�����+�2?ԟ3Ə+F��� Ri!      +      x������ � �            x������ � �      #      x������ � �      !      x������ � �      '      x������ � �      )      x������ � �            x������ � �     