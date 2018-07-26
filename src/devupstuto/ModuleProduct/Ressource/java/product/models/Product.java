package nkap.mobile.nkap;
    
    public class Product {

        protected int id;
        private String name;
        private String description; 
        
        private Image image;

        private Category category;

        private Subcategory subcategory;

        public List<Storage> storage;


        
        public Product(){ 
                          
}

        public int getId() {
            return this.id;
        }
        public String getName() {
            return this.name;
        }

        public void setName(String name) {
            this.name = name;
        }
        
        public String getDescription() {
            return this.description;
        }

        public void setDescription(String description) {
            this.description = description;
        }
        
        function Image getImage() {
            return this.image;
        }
        function void setImage(Image image) {
            this.image = image;
        }
                        
        function Category getCategory() {
            return this.category;
        }
        function void setCategory(Category category) {
            this.category = category;
        }
                        
        function Subcategory getSubcategory() {
            return this.subcategory;
        }
        function void setSubcategory(Subcategory subcategory) {
            this.subcategory = subcategory;
        }
                        
        function List<Storage> getStorage() {
            return this.storage;
        }
}
