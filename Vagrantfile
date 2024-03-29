Vagrant.configure("2") do |config|
    # Configure the box to use
    config.vm.box = "ubuntu/xenial64"

    # Configure the network interfaces
    config.vm.network :private_network, ip:    "192.168.33.10"
    config.vm.network :forwarded_port,  guest: 80,    host: 2080
    config.vm.network :forwarded_port,  guest: 8081,  host: 2081
    config.vm.network :forwarded_port,  guest: 3306,  host: 2006
    config.vm.network :forwarded_port,  guest: 27017, host: 2017

    # Configure shared folders
    config.vm.synced_folder ".",  "/vagrant", id: "vagrant-root", :nfs => true
    #config.vm.synced_folder "..", "/var/www", id: "application",  :nfs => true

    # Configure VirtualBox environment
    config.vm.provider :virtualbox do |v|
        v.name = "Magento Driver - " + (0...8).map { (65 + rand(26)).chr }.join
        v.customize [ "modifyvm", :id, "--memory", 512 ]
    end

    # Provision the box
    config.vm.provision :ansible do |ansible|
        ansible.extra_vars = { ansible_ssh_user: 'vagrant' }
        ansible.playbook = "ansible/site.yml"
    end
end
